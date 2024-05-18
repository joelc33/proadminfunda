#!/bin/bash
sudo a2dismod php$1
sudo a2enmod php$2
sudo /etc/init.d/apache2 restart
sudo ln -sfn /usr/bin/php$2 /etc/alternatives/php;
#sudo update-alternatives –set php /usr/bin/php$2
#sudo systemctl restart apache2
exit
