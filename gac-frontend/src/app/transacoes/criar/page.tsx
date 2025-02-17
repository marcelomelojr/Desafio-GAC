'use client'

import {Input} from "@nextui-org/input";
import {Button} from "@nextui-org/react";
import {useEffect, useState} from "react";
import {createTransactionAction} from "@/actions/wallet";
import {notifyCustom} from "@/utils/Notify";
import {walletService} from "@/services/walletService";

const CriarTransacoesPage = () => {

    const [amount, setAmount] = useState('');
    const [payee, setPayee] = useState('');

    const [balance, setBalance] = useState(0);

    const createTransaction = async () => {
        if (Number(amount) > balance) {
            notifyCustom("Saldo insuficiente. Faça um deposito para realizar esta transferência", "error")
        }

        if (!amount ||!payee) {
            notifyCustom("Preencha todos os campos para realizar a transação", "error")
            return;
        }
        const response = await createTransactionAction(amount, payee);


        if (response.transaction) {
            notifyCustom("Transação realizada com sucesso!", "success")
            setAmount('');
            setPayee('');
            return;
        } else {
            notifyCustom("Ocorreu um erro ao realizar a transação.", "error")
            return;
        }
    }

    const handleBalance = async () => {
        const response = await walletService.getBalance();

        setBalance(response);
    }

    useEffect(() => {
        handleBalance();
    }, []);

    const alterAmountValue = (amount: string) => {
        amount = Number(amount);

        if (amount < 0) {
            amount = 0;
        }

        if (amount > balance) {
            notifyCustom("Saldo insuficiente. Faça um deposito para realizar esta transferência", "error")
        }

        setAmount(amount)
    }

    function currencyFormat(num: string) {
        console.log('R$' + Number(num).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
        return
    }

    return (
        <section className="flex flex-col max-w-xl mx-auto px-16 py-10 shadow border-gray-50">
            <h2 className="text-2xl font-bold mb-4 text-center">Transferência</h2>

            <div className="space-y-4">
                <Input
                    label="Destinatario"
                    type="text"
                    onChange={(e) => setPayee(e.target.value)}
                    id="payee"
                    name="payee"
                    placeholder="Digite o CPF, ou o e-mail do destinatario"
                />


                <Input
                    label="Valor (R$)"
                    type="text"
                    id="amount"
                    name="amount"
                    onChange={(e) => alterAmountValue(e.target.value)}
                    value={amount}
                    min={0}
                    step={0.01}
                    placeholder="Digte o Valor a ser transferido"
                    startContent={
                        <div className="pointer-events-none flex items-center">
                            <span className="text-default-400 text-small">$</span>
                        </div>
                    }
                />


                <Button
                    color="success"
                    size="lg"
                    className="w-full"
                    variant="solid"
                    onPress={() => {
                        console.log("Transferir", amount, payee)
                        createTransaction()
                    }}
                >
                    <p className={"text-white"}>Transferir</p>
                </Button>
            </div>

        </section>
    )
}

export default CriarTransacoesPage;

