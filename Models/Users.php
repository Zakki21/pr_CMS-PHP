<?php
	namespace Models;
	use App;
	
	class Users {
		public function getUsersToStatus () {
			return App::$db->execute('SELECT * FROM users WHERE status=0');
		}
		
		public function addUser ($data) {
			$status = App::$db->execute('INSERT INTO users
																		(fname,sname,age,password,notifications,color,hobbies,food,text,image)
																   	VALUES ("'.$data['fname'].'", "'.$data['sname'].'", "'.$data['age'].'", "'.$data['password'].'", "'.$data['radio'].'", "'.$data['checkbox'].'", "'.$data['select'].'", "'.$data['selectsize'].'", "'.$data['textarea'].'", "'.$data['hidden'].'")
																  ');
			if ($status)
				return true;
			else
				return false;
		}
		
		public function updateUsersStatusToId ($id) {
			return App::$db->execute('UPDATE users SET status=1 WHERE id='.$id);
		}
	}