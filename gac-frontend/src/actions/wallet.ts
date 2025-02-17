'use server'

import {walletService} from "@/services/walletService";

export async function createTransactionAction(amount: string, payee: string) {
    return await walletService.createTransaction(amount, payee);
}

export async function getAllTransactionAction(){
    return await walletService.getAllTransactions();
}

export async function makeDepositAction(amount: string) {
    return await walletService.makeDeposit(amount);
}

export async function makeRollbackAction(transactionId: string) {
    return await walletService.transactionRollback(transactionId);
}