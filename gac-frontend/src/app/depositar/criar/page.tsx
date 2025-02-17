'use client'

import {Input} from "@nextui-org/input";
import {Button} from "@nextui-org/react";
import {useState} from "react";

import {createTransactionAction, makeDepositAction} from "@/actions/wallet";
import {notifyCustom} from "@/utils/Notify";


const CriarDepositoPage = () => {

    const [amount, setAmount] = useState('');
    const makeDeposit = async () => {
        const response = await makeDepositAction(amount);

        if (response.success) {
            notifyCustom("Deposito realizado com sucesso!", "success")
            setAmount('');
            return;
        } else {
            notifyCustom("Ocorreu um erro ao realizar o deposito.", "error")
            return;
        }
    }

    return (
        <section className="flex flex-col max-w-xl mx-auto px-16 py-10 shadow border-gray-50">
            <h2 className="text-2xl font-bold mb-4 text-center">Depositar</h2>

            <div className="space-y-4">
                <Input
                    label="Valor (R$)"
                    type="number"
                    id="amount"
                    name="amount"
                    onChange={(e) => setAmount(e.target.value)}
                    min={0}
                    step={0.01}
                    placeholder="Digte o Valor a ser depositado"
                />

                <Button
                    color="success"
                    size="lg"
                    className="w-full"
                    variant="solid"
                    onPress={() => {
                        makeDeposit()
                    }}
                >
                    <p className={"text-white"}>Depositar</p>
                </Button>
            </div>

        </section>
    )
}

export default CriarDepositoPage;

