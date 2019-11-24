
# any future command that fails will exit the script
set -e

cd /var/www/html/

# Delete the old repo
sudo rm -rf engima

cd ../../..
cd
# clone the repo again
git clone git@gitlab.informatika.org:if3110-2019-02-k03-16/engima.git
# move repo to var/www/html
sudo mv engima/  /var/www/html/
