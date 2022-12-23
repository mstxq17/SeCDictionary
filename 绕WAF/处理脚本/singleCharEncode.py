#!/usr/bin/env python3
# -*- coding:utf-8 -*-

"""
生成0-255单字符的url编码，用来绕waf测试
"""

with open("../singleCharEncode.txt", "w") as f:
    for i in range(0, 256):
        ok_str = "%" + str(hex(i)).split("0x")[1].zfill(2)
        f.write(ok_str + "\n")
