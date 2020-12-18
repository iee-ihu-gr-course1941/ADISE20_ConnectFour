<?php


function show_piece ($row,$col){
    global $mysqli;

    $sql = 'select * from board where row=? and col=?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii',$row,$col);
    $stmt->execute();
    $result = $stmt->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI-ASSOC),JSON_PRETTY_PRINT);
}

function move_piece($row,$col,$token){
    if($token==null || token==''){
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"token is not set"]);
        exit;
    }

    $color = current_color($token);
    if($color==null){
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"token is not set"]);
        exit;
    }

    $status = read_status();
    if($status['status']!='started'){
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"token is not set"]);
        exit;
    }
    if($status['player_turn']!=$color){
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"token is not set"]);
        exit;
    }

    $originalBoard = read_board();
    $board = convert_board($originalBoard);
    $n = add_valid_moves_to_piece($board,$color,$row,$col);
    if($n==0){
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"token is not set"]);
        exit;
    }

    
}


?>