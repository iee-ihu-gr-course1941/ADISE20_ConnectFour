<?php

function show_users(){
    global $myslqi;
    $sql= 'select username,piece_color  from players';
    $stmt = $myslqi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function show_user($b){
    global $mysqli;
    $sql = ' select username,piece_color from players where piece_color=?';
    $stmt = $myslqi->bind_param('s',$b);
    $stmt->execute();
    $result = $st->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function set_user($b,$input){
    if(!isset($input['username'])){
        header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"No username given."]);
		exit;
    }
    $username = $input['username'];
    global $myslqi;
    $sql= 'select count(*) as c from players where piece_color=? and username is not null';
    $stmt=$myslqi->prepare($sql);
    $stmt->bind_param('s',$b);
    $stmt->execute();
    $result = $stmt->get_result();
    $r = $result->fetch_all(MYSQLI_ASSOC);
    if($r[0]['c']>0){
        header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Player $b is already set. Please select another color."]);
		exit;
    }
    $sql = 'update players set username=?, token=md5(CONCAT( ?, NOW()))  where piece_color=?';
	$st2 = $mysqli->prepare($sql);
	$st2->bind_param('sss',$username,$username,$b);
    $st2->execute();
    
    # εδω καλειται η php functino που κανει update τον game_status

    #εδω εμφανιζουμε τον updated πινακα game_status
    $sql = 'select * from players where piece_color=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$b);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
    

    function handle_user($method, $b,$input) {
        if($method=='GET') {
            show_user($b);
        } else if($method=='PUT') {
            set_user($b,$input);
        }
    }

    function current_color($token) {
	
        global $mysqli;
        if($token==null) {return(null);}
        $sql = 'select * from players where token=?';
        $st = $mysqli->prepare($sql);
        $st->bind_param('s',$token);
        $st->execute();
        $res = $st->get_result();
        if($row=$res->fetch_assoc()) {
            return($row['piece_color']);
        }
        return(null);
    }
}