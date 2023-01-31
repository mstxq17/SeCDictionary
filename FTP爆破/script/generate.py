#!/usr/bin/env python
# -*- coding:utf-8 -*-

import re
import os

number_pattern = re.compile("#number#")

def digital_permutation(length=4, padding=True) -> list:
    start = 0
    end = int('9'*4)
    permutations = []
    for num in range(start, end+1):
        if padding:
            num = str(num).zfill(length)
        permutations.append(str(num))
    return permutations


def generate(file):
    with open(file, "r") as f:
        for line in f:
            clean_item = line.strip()
            length = 4
            padding = True
            results = []
            for each in digital_permutation(length=length, padding=padding):
                sub_number = number_pattern.sub(each, clean_item)
                results.append(sub_number)
                print(sub_number)
            with open(f"../pass#number#4.txt", "w") as f:
                for item in results:
                    f.write(item + os.linesep)

def main():
    generate(file="template/pass.txt")

if __name__ == '__main__':
    main()