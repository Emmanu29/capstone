import socketserver
import hashlib
import numpy as np
import asyncio
import websockets
import json
from scipy import signal  # For filtering
import mysql.connector
import struct

# Constants
K = [0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xCA62C1D6]
H0 = [0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0]

def left_rotate(n, b):
    return ((n << b) | (n >> (32 - b))) & 0xFFFFFFFF

def padding(message):
    if isinstance(message, str):
        message = message.encode('utf-8')  # Ensure the message is in bytes
    original_length_bits = (len(message) * 8) & 0xFFFFFFFFFFFFFFFF
    message += b'\x80'
    while (len(message) % 64) != 56:
        message += b'\x00'
    message += struct.pack('>Q', original_length_bits)
    return message

def split_into_blocks(message):
    return [message[i:i + 64] for i in range(0, len(message), 64)]

def process_block(block, H):
    W = [0] * 80
    for t in range(16):
        W[t] = struct.unpack('>I', block[t * 4:(t + 1) * 4])[0]

    for t in range(16, 80):
        W[t] = left_rotate(W[t - 3] ^ W[t - 8] ^ W[t - 14] ^ W[t - 16], 1)

    A, B, C, D, E = H[:5]
    F = 0

    for t in range(80):
        if 0 <= t <= 19:
            func = (B & C) | ((~B) & D)
            k = K[0]
        elif 20 <= t <= 39:
            func = B ^ C ^ D
            k = K[1]
        elif 40 <= t <= 59:
            func = (B & C) | (B & D) | (C & D)
            k = K[2]
        else:
            func = B ^ C ^ D
            k = K[3]

        TEMP1 = (left_rotate(A, 5) + func + E + k + W[t]) & 0xFFFFFFFF
        E = D
        D = C
        C = left_rotate(B, 30)
        B = A
        A = TEMP1

        mix = A ^ C ^ D
        A_prime = mix
        C_prime = mix
        D_prime = mix
        TEMP2 = (left_rotate(A, 5) + func + E + k + W[t]) & 0xFFFFFFFF
        E = D_prime
        D = C_prime
        C = left_rotate(B, 30)
        B = A_prime
        A = TEMP2

        H[0] = (H[0] + A) & 0xFFFFFFFF
        H[1] = (H[1] + B) & 0xFFFFFFFF
        H[2] = (H[2] + C) & 0xFFFFFFFF
        H[3] = (H[3] + D) & 0xFFFFFFFF
        H[4] = (H[4] + E) & 0xFFFFFFFF

    return H

def msha1(message):
    message = padding(message)
    blocks = split_into_blocks(message)
    H = H0[:]

    for block in blocks:
        H = process_block(block, H)

    return b''.join(struct.pack('>I', h) for h in H)

# Database connection details
mydb = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="laravel"
)

# Create a cursor object for database interaction
mycursor = mydb.cursor()

emptyBase = "ESP32_1,0,0.00"
values = emptyBase.split(",")


class MyTCPHandler(socketserver.BaseRequestHandler):
    def handle(self):
        data = self.request.recv(1024).strip().decode()
        values = data.split(",")

        # Sample values from your code
       
       
        esp32 = values[0]
        ecg = values[1]
        bpm = values[2]
        respiratory_rate = values[3]
        core_temp = values[4]

        hash_value = msha1(data)

        # SQL query
        sql = "UPDATE monitorings SET ecg = %s, bpm = %s, respiratoryRate = %s, coreTemp = %s, hashValue = %s WHERE esp32 = %s"
        value = ( ecg, bpm, respiratory_rate, core_temp,hash_value.hex(),esp32)

        print(value)
        # Execute the SQL statement
        mycursor.execute(sql, value)

        # Commit changes to the database 
        mydb.commit()

       
       

if __name__ == "__main__":
    HOST, PORT = "0.0.0.0", 1221  # Listen on all interfaces

    with socketserver.TCPServer((HOST, PORT), MyTCPHandler) as server:
        server.serve_forever()
