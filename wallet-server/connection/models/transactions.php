<?php
require_once '../connection.php';

class Transactions
{
    private static function checkError($sql)
    {
        if (!$sql) {
            echo "SQL preperation error";
            return false;

        }
        if (!$sql->execute()) {
            echo "SQL execution error";
            return false;
        }
        return true;
    }

    public static function getTransactionHistory($user_id, $conn)
    {

        $sql = $conn->prepare('SELECT transactions.transaction_id,transactions.amount,
        transactions.created_at,transaction_types.type_name FROM transactions JOIN transaction_types
        ON transactions.transaction_type_id = transaction_types.id
        WHERE transactions.user_id = ?');
        $sql->bind_param('i', $user_id);

        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result()->fetch_assoc();

        if ($result) {
            return $result;
        }
        return $result;
    }
    public static function transactionsCount($conn)
    {

        $sql = $conn->prepare('SELECT COUNT(*) AS total_transactions FROM transactions');

        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result()->fetch_assoc();
        $transactions = $result['total_transactions'];


        return $transactions;

    }
    public static function addTransaction($user_id,$amount,$type,$conn) {
        $sql = $conn->prepare('INSERT INTO transactions (user_id,amount,transaction_type_id)
        VALUES(?,?,?)');
        $sql->bind_param('idi', $user_id, $amount, $type);

        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
}