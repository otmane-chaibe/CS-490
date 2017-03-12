<?php

class User {

	public static function getUserByUCID($ucid) {
		global $mysqli;
		$sql = "SELECT id, password, `name`, role FROM users WHERE ucid = '$ucid'";
		$stmt = null;
		$mysqli->query($sql);
		$stmt->bind_result($id, $password, $name, $role);

		# todo: complete method...

		if (empty($id)) { return null; }

		return [
			'id'       => (int) $id,
			'ucid'     => $ucid,
			'password' => $password,
			'name'     => $name,
			'role'     => (int) $role,
		];
	}
}
