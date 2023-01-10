// https://dev.mysql.com/doc/refman/5.7/en/built-in-function-reference.html
selector = document.querySelectorAll('#docs-body > div > div.table > div:nth-child(3) > table > tbody > tr > th > a > code');
alls = "";
_function = "";
for (index = 0; index < selector.length; index++) {
    _function = selector[index].textContent;
    console.log(_function);
    alls += _function + '\n'
}

var aux = document.createElement("textarea");
aux.value = alls;
document.body.appendChild(aux);
aux.select();document.execCommand("copy");
document.body.removeChild(aux);
console.log("复制成功!");