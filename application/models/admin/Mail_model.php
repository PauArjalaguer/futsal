<?php

Class Mail_model extends CI_Model {

    function insert_mail($senderName, $receiverName, $subject,$message, $idSenderClub, $idReceiverClub) {

        $data = array('subject'=>$subject,'senderName' => $senderName, 'receiverName' => $receiverName, 'message' => $message, 'idSender' => $idSenderClub, 'idReceiver' => $idReceiverClub);
        $this->db->set('insertedDate', 'NOW()', FALSE);
        $this->db->insert('mailControl', $data);
    }

    function get_mail_queue() {
        $this->db->select('m.id,senderName, receiverName, subject,message, u1.email as localEmail, u2.email as visitorEmail');
        $this->db->from('mailControl m ');
        $this->db->join('usersAccounts u1', 'u1.id=idSender');
        $this->db->join('usersAccounts u2', 'u2.id=idReceiver');
        $this->db->limit(10,0);
        $this->db->where('status', 0);
        $query = $this->db->get();
        echo $this->db->last_query();
        return $query->result();
    }

    function mark_as_send($id) {
        $data = array(
            'status' => "1"
        );
        $this->db->set('sendDate', 'now()', false);
        $this->db->where('id', $id);
         $this->db->update('mailControl', $data);
    }

    function get_mail_notread($idReceiver) {
        $this->db->select('m.id,senderName, receiverName, message, datediff(now(),insertedDate) as days, c.image');
        $this->db->from('mailControl m ');
        $this->db->join('usersAccounts u','u.id=m.idSender','left');
        $this->db->join('clubs c','c.id=u.idClub','left');
        $this->db->where('readDate', NULL);
        $this->db->where('idReceiver', $idReceiver);
        $this->db->order_by('insertedDate','desc');
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

}

?>