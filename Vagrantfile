# -*- mode: ruby -*-
# vi: set ft=ruby :

_VAGRANTFILE_API_VERSION = "2"
_VAGRANT_BOX = "ubuntu/bionic64"
_VAGRANT_BOX_MEMORY = 1024
_VIRTUAL_BOX_NAME = "lv-piggybank"

Vagrant.configure(_VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = _VAGRANT_BOX
  config.vm.box_check_update = true
  config.vm.hostname = _VIRTUAL_BOX_NAME
  config.vm.network :private_network, ip: "192.168.254.12"
  config.hostsupdater.aliases = ["root.lv-piggybank", "app.lv-piggybank"]

  config.vm.synced_folder ".", "/var/www/lv-piggybank", type: "nfs", nfs_version: 4, nfs_udp: false, mount_options: ['sec=sys', 'fsc']

  # ensure box name
  config.vm.define _VIRTUAL_BOX_NAME do |t|
  end

  # configure virtual box
  config.vm.provider :virtualbox do |vb|
    vb.name = _VIRTUAL_BOX_NAME
    vb.linked_clone = true
    vb.memory = "1024"
    vb.cpus = "2"
  end

  # provision vm os
  config.vm.provision :shell, inline: <<-SHELL
    export DEBIAN_FRONTEND=noninteractive
    apt-get update -q && apt-get upgrade -y -q
    apt-get install -y -q apache2
    a2enmod rewrite
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
    apt-get install -y -q mysql-server
    apt-get install -y -q unzip zip
    apt-get install -y -q php7.2 php-mbstring php-mysql php-xdebug php-xml php-zip
    apt-get install -y -q nodejs npm
  SHELL

  # copy files required to provision software
  # (as recommended by https://www.vagrantup.com/docs/provisioning/file.html)
  config.vm.provision :file, source: "vagrant/files", destination: "/tmp/provision"

  # provision-files php
  config.vm.provision :shell, inline: <<-SHELL
    mv /tmp/provision/php/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini
  SHELL

  # provision-files apache
  config.vm.provision :shell, inline: <<-SHELL
    mv /tmp/provision/www/index.php /var/www
    mv /tmp/provision/apache2/001-root.lv-piggybank.conf /etc/apache2/sites-available
    mv /tmp/provision/apache2/002-app.lv-piggybank.conf /etc/apache2/sites-available
    a2dissite 000-default.conf
    a2ensite 001-root.lv-piggybank.conf 002-app.lv-piggybank.conf
    systemctl reload apache2.service
  SHELL

  # provision-shell
  config.vm.provision :shell, path: "vagrant/shell/install-composer.sh"
  config.vm.provision :shell, path: "vagrant/shell/install-yarn.sh"
  config.vm.provision :shell, path: "vagrant/shell/mysql-allow-remote.sh"
  config.vm.provision :shell, path: "vagrant/shell/allow-sshd-password.sh"

  # cleanup
  config.vm.provision :shell, inline: "rm -rf /tmp/provision"
end
