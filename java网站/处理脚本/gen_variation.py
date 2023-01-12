#!/usr/bin/env python3
# -*- coding:utf-8 -*-

import os

append = "-dev"

new_file_paths = []
# 处理文件
with open("../web-inf.txt", "r") as f:
    for line in f:
        filename = os.path.basename(line)
        dir_path = os.path.dirname(line)
        split_name = filename.split('.')
        name, suffix = split_name[0], split_name[1]
        new_file_name = name + append + "." + suffix
        new_file_path = os.path.join(dir_path, new_file_name)
        new_file_paths.append(new_file_path.strip())
# 生成新文件
with open("../web-inf"+append+".txt", "w") as f:
    for filename in new_file_paths:
        f.write(filename + "\n")
