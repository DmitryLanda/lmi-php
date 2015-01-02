Сайт Лицея Математики и информатики
===================================

Установка
----------
**Если в качестве ОС используется линукс - первые 2 шага можно пропустить**
 - Скачать и установить [Virtual Box][1]
 - Скачать и установить любой дистрибутив Linux
  - Без GUI [Ubuntu server][2] - "голая" система без графической оболочки
  - С GUI [Ubuntu][3] - полноценная система с графической оболочкой
 - установить следующие php пакеты
    `php5 php5-cli php5-curl php5-mysql php5-xdebug`
    команда для установки `sudo apt-get install <список пакетов через пробел>`
 - установить и настроить `mysql` сервер ([например так][4])
 - установить web сервер, например `apache2` - `sudo apt-get install apache2`
 - [создать ssh ключ для github][5] - опционально, позволит избежать ввода пароля каждый раз при обращении к серверу
 - Форкнуть репозитарий к себе (кнопка Fork в верхнем правом углу)
 - клонировать репозитарий с проектом `git clone git@github.com:<username>/lmi-php.git`
 - Добавить ссылку на базовый репозиторий `git remote add upstream git@github.com:DmitryLanda/lmi-php.git`
 - Указать данные для доступа к базе в [конфигурационном файле][6]
 - настроить виртуальный сервер - cоздать файл `sudo touch /etc/apache2/sites-available/lmi` и записать в него следующее:
  
   ```xml
   <VirtualHost *:80>
      ServerName lmi-school.local
      DocumentRoot <path to lmi>/web
      <Directory "<path to lmi>/web">
          Options Indexes MultiViews FollowSymLinks
          AllowOverride All
          Order deny,allow
          Deny from all
          Allow from all
          #Require all granted
      </Directory>
  </VirtualHost>
   ```
   
- Добавить сайт в `/etc/hosts` - открыть для редактирования файл `/etc/hosts` 
  и добавить туда `127.0.0.1 lmi-school.local` в любое место (например в начало файла)
- "включить" сайт `sudo a2ensite lmi`
- перезагрузить apache2 - `sudo service apache2 restart`

**Для apache2 версии больше 2.4 потребуется раскоментировать (удалить #) строчку `Require all granted` в файле `/etc/apache2/sites-available/lmi`**

Пул реквесты
------------
 - Перейти в `master` ветку `git checkout master`
 - Подгрузить последние изменения `git pull upstream master`
 - Создать новую ветку `git branch <имя ветки>`
 - Перейти в новую ветку `git checkout <имя ветки>`
 - Сделать нужные изменения
 - Добавить **только необходимые** файлы `git add <список файлов через пробел>`
 - Создать комит `git commit -m "название комита на английском языке"`
 - Добавить ветку в свой даленный репозиторий `git push origin <имя ветки>`
 - [Создать пулл реквест][7]

[1]: https://www.virtualbox.org/wiki/Downloads
[2]: http://www.ubuntu.com/download/server
[3]: http://www.ubuntu.com/download/desktop
[4]: http://help.ubuntu.ru/wiki/mysql
[5]: https://help.github.com/articles/generating-ssh-keys/
[6]: https://github.com/DmitryLanda/lmi-php/blob/master/src/LmiSchool/Resources/config.json#L6-L9
[7]: https://help.github.com/articles/creating-a-pull-request/
