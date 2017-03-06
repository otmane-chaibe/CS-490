<?php

class User
{

	public static function getUserByUCID($ucid)
	{
		global $mysqli;

		$sql = 'SELECT id, password, `name`, role FROM users WHERE ucid = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('s', $ucid);
		$stmt->execute();
		$stmt->bind_result($id, $password, $name, $role);
		$stmt->fetch();
		$stmt->close();

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
