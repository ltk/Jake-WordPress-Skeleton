# Jake WordPress Skeleton

This is simply a skeleton repo for a WordPress site. Use it to jump-start your WordPress site repos, or fork it and customize it to your own liking!

## How to Use
Fork this repo. Clone your fork using `git clone --recursive git@github.com:your-username/Your-Forked-Repo.git`. Checkout the desired WordPress version by running `cd wp; git checkout 3.5-branch` where `3.5-branch` is the name of the desired branch. Fill in your project/connection information in `install/config-sample.php`, and rename the file `config.php`. Setup a virtual host for the domain name you chose within `config.php` and start your local server. Then from the command line, cd to the root of the repo and run `php install/install.php`. Delete the `install` directory and you're good to go.