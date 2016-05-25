<?php



//
//
//    public function createCommande($user_id,$prixTotal){
//        $conn=$this->db;
//        $conn->beginTransaction();
//        $requestSQL=$conn->prepare('select sum(prix*quantite) as prix from paniers WHERE
//                                    user_id = :idUser and commande_id is NULL ');
//        $requestSQL->execute(['idUser' =>$user_id]);
//        $prix=$requestSQL->fetch()['prix'];
//        $conn->commit();
//        $conn->beginTransaction();
//        $requestSQL=$conn->prepare(' insert into commandes(user_id,prix,etat_id) values  (?,?,?)');
//        $requestSQL->execute([$user_id,$prix,1]);
//        $lastinsertid=$conn->lastInsertId();
//        $requestSQL=$conn->prepare(' uptade paniers set commande_id=? where user_id=?
//                            and commande_id is null');
//        $requestSQL->execute([$lastinsertid,$user_id]);
//        $conn->commit();
//}
