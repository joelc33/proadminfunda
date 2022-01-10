#!/bin/bash
# -*- ENCODING: UTF-8 -*-
#php symfony propel:init-admin aplicacion $1 $1
wget http://localhost/gobel/web/index.php/$1
cp -R cache/frontend/prod/modules/auto$1/templates/ apps/frontend/modules/$1/
cp cache/frontend/prod/modules/auto$1/actions/actions.class.php apps/frontend/modules/$1/actions/
chmod -R 777 ../gobel/
rm $1
sed -i "s/auto$1Actions/$1Actions/g" apps/frontend/modules/$1/actions/actions.class.php;
exit
