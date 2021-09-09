#HIPHOPRAW

* [hiphopraw.com](http://hiphopraw.com/) is a video upload platform that will enable members to upload videos
and engage in the first truly hiphop social network.
* Once the vidoes have been uploaded the member can send invitations to their friends
email from the platform for the friends to sign up and join the platform to vote on the
senders videos.
* The membership will be free and once the visitor signs up they will be able to view their
profile.
* 8 videos from each category with the most like votes will be entered into a contest in order
to select a winner.
* Each winner of the contest will be eligible for prizes provided by sponsors.
* Members of the site will be able to invite friends, send messages to their friends, vote on
vidoes.
* In order to view the videos you will not be required to join the website.
* The contest will have a bracket structure for the video contest.


Project update/setup
`composer self-update`
`composer update --prefer-dist`

$ rm -rf fuel/core/ docs/
$ rm -rf fuel/packages/auth/ fuel/packages/email/ fuel/packages/oil/
$ rm -rf fuel/packages/orm/ fuel/packages/parser/ fuel/vendor/

DB migration
$ php oil refine migrate
$ php oil refine migrate:current
$ php oil refine migrate:up
$ php oil refine migrate:down
$ php oil refine migrate --version=10

Module based DB migration
$ php oil refine migrate -all
$ php oil refine migrate --modules=module1,module2 --packages=package1
$ php oil refine migrate:up --packages=package1
$ php oil refine migrate:down --modules=module1,module2 --default
$ php oil refine migrate --version=10