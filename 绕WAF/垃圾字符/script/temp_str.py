#!/usr/bin/python
# -*- coding:utf-8 -*-

from random import randint
index = 0
with open('../tempRandom.txt','w') as f:
    # for k in range(0, 1000000):
    #     f.write("{}".format('a'))
    for k in range(0, 1000000):
        random_int = chr(randint(0, 255))
        f.write(str(random_int))
    # f.write(chr(randint(0,255))*100000)
    # f.write("&id[]"*10000)
f.close()