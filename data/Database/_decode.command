#/usr/bin/bash
cd -- "$(dirname "$0")"
rm *.txt
php -r "\$d=opendir('.');while((\$f=readdir(\$d))!==false){\$e=explode('.',\$f);if(sizeof(\$e)>0&&\$e[1]=='db'){echo 'Decoding '.\$f.PHP_EOL;\$FO=json_decode(gzuncompress(file_get_contents(\$f)));ob_start();\$dump=print_r(\$FO);\$dump=ob_get_contents();ob_end_clean();file_put_contents(\$f.'.txt',\$dump);}}"
exit