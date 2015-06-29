# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise32"
  config.vm.provision :shell, :path => "./bin/vagrant/bootstrap.sh"
  config.vm.network :forwarded_port, host: 4567, guest: 80
  config.vm.network :forwarded_port, host: 4568, guest: 8080
  config.vm.network :forwarded_port, host: 3456, guest: 3306

  config.vm.synced_folder "./",
    "/vagrant",
    :owner => "vagrant",
    :group => "vagrant",
    type: "rsync",
    rsync__auto: "true",
    rsync__exclude: ["src/public/assets/", ".git/", "composer.lock", ".idea/", "src/data/", "src/vendor/", "src/assets/build/", "src/assets/tmp/", "src/assets/source/bower_components", "src/assets/node_modules"],
    rsync__args: ["--verbose", "--archive", "--delete", "--stats"]

  config.vm.provider :virtualbox do |vb|
    # Solves an issue with dns resolving (nodejs)
    vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
    vb.customize ['modifyvm', :id, '--natdnsproxy1', 'off']
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

  config.trigger.after :up do
    run "vagrant ssh -c 'sh /vagrant/bin/vagrant/boot.sh'"
    run "vagrant rsync-auto"
  end
end
