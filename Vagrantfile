Vagrant.configure(2) do |config|

    config.vm.define "zerbikat" do |symfony|
        # Base template for virtualbox, we use ubuntu 14.04 here
        symfony.vm.box = "ubuntu/xenial64"
        # Domain on which our application will respond later on
        symfony.vm.hostname  = "zerbikat.test"
        # IP address will be used by the VM
        symfony.vm.network :private_network, ip: "192.168.33.151"

        # Tell vagrant to run ansible as a provisioner
        symfony.vm.provision :ansible do |ansible|
            # where the playbook is located
            ansible.playbook = "ansible/playbook.yml"
        end
    end

    # Access the shared vagrant directory via NFS, otherwise slow on mac and windows
    ################################################################################
    ################################################################################
    #### ADI!!! Windows edo MAC-en lan egiteko gaitu hurrengoa
    ################################################################################
    ################################################################################
    #config.vm.synced_folder ".", "/vagrant", type: "nfs"

    config.vm.provider "virtualbox" do |v|
        # tell virtualbox to give our machine 1 GB RAM and 2 Cores
        v.memory = 2048
        v.cpus = 2
    end
end

