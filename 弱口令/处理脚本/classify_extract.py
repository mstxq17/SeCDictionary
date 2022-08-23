#!/usr/bin/env python3
# -*- coding:utf-8 -*-

def check_line(line):
    if line.startswith('#'):
        return False
    else:
        return True


with open("basic.data", "r") as dict_file, open("user.txt", "w") as user_file, open("pwd.txt", "w") as pwd_file:
    # read line one by one
    for line in dict_file:
        if check_line(line):
            line = line.strip().split(' ')
            result = list(filter(None, line))
            try:
                user_file.write(result[0].strip() + '\n')
            except Exception as e:
                print(line, result)
            try:
                pwd_file.write(result[1].strip() + '\n')
            except Exception as e:
                print(line, result)
