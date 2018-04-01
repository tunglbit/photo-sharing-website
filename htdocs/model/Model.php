<?php
    class Account {
        public $username;
        public $email;
        public $password;
        public $role;

        public function __construct($username, $email, $password, $role) {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
        }
    }
	
	class Image {
        public $name;
        public $owner;
        public $theme;
        public $uploaddate;
        public $noview;
        public $nodownload;

        public function __construct($name, $owner, $theme, $uploaddate, $noview, $nodownload) {
            $this->name = $name;
            $this->owner = $owner;
            $this->theme = $theme;
            $this->uploaddate = $uploaddate;
            $this->noview = $noview;
            $this->nodownload = $nodownload;
        }
    }
	
	class Likes {
        public $emailOwner;
        public $image;
        public $emailLike;

        public function __construct($emailOwner, $image, $emailLike) {
            $this->emailOwner = $emailOwner;
            $this->image = $image;
            $this->emailLike = $emailLike;
        }
    }
	
	class Comments {
        public $owner;
        public $email;
        public $image;
        public $comment;
        public $uploaddate;

        public function __construct($owner, $email, $image, $comment, $uploaddate) {
            $this->owner = $owner;
            $this->email = $email;
            $this->image = $image;
            $this->comment = $comment;
            $this->uploaddate = $uploaddate;
        }
    }

	class Themes {
        public $name;

        public function __construct($name) {
            $this->name = $name;
        }
    }
	
    class Response {
        public static $SUCCESS = 1;
        public static $FAILED = 0;
        public static $ERROR = -1;

        public $status;
        public $message;
        public $data;

        public function __construct() {
			
        }
    }
?>