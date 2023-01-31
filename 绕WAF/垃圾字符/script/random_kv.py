#coding=utf-8
import random, string
from urllib import parse
# code by yzddMr6
varname_min = 5
varname_max = 15
data_min = 20
data_max = 25
num_min = 50
num_max = 100

def randstr(length):
    str_list = [random.choice(string.ascii_letters) for i in range(length)]
    random_str = ''.join(str_list)
    return random_str

def main():
    data = {}
    for i in range(num_min,num_max):
        data[randstr(random.randint(varname_min,varname_max))]=randstr(random.randint(data_min,data_max))
    bypass_str = '&'+parse.urlencode(data)+'&'
    print(bypass_str)
    with open("../bypass_kv.txt", "w") as f:
        f.write(bypass_str)

main()