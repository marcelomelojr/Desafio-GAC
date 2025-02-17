'use client'

import React, {useState} from "react";
import {Input} from "@nextui-org/input";
import {Button, Divider} from "@nextui-org/react";
import { signIn } from '@/utils/signIn'
import { useRouter } from 'next/navigation'
import MyLogo from "@/assets/icons/MyLogo";
import {Spinner} from "@nextui-org/spinner";
import {createUser} from "@/actions/user";
import {notifyCustom} from "@/utils/Notify";

const CriarConta = () => {

    const router = useRouter();

    const [loading, setLoading] = useState(false)
    const [invalidCredentials, setInvalidCredentials] = useState(false)


    const [name, setName] = useState('')
    const [document, setDocument] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')



    const onSubmit = async () => {
        try {
            setLoading(true)
            setInvalidCredentials(false)
            const response = await createUser({
                name,
                document,
                email,
                password
            })

            if (response?.status === 201) {
                notifyCustom("Produto criado com sucesso", "success")
            }

            router.push('/login')
            window.location.href = '/login'
        } catch {
            setInvalidCredentials(true)
        } finally {
            setLoading(false)
        }
    }

    return (

        <div className={"flex items-center justify-center h-svh md:grid-cols-2 flex-col w-full"}>
            <div className={"flex flex-col px-10 justify-center items-center min-w-[500px]"}>
                <div className={"flex flex-col space-y-2 my-4 w-full"}>
                    <h1 className={"text-2xl text-gray-600 font-bold"}>Crie sua conta</h1>
                    <h2 className={"text-sm text-gray-300"}>Crie sua conta e tenha acesso a sua carteira!</h2>
                </div>
                <div className={"container"}>
                    <form className={"flex flex-col items-center justify-center w-full space-y-4"}>

                        <div className="flex w-full flex-wrap items-end md:flex-nowrap mb-6 md:mb-0 gap-4">
                            <Input type="text"
                                   value={name}
                                   description={!name ? "* Campo obrigatório" : ""}
                                   label="Nome"
                                   onChange={(e) => setName(e.target.value)}
                            />
                        </div>

                        <div className="flex w-full flex-wrap items-end md:flex-nowrap mb-6 md:mb-0 gap-4">
                            <Input type="text"
                                   value={document}
                                   description={!document ? "* Campo obrigatório" : ""}
                                   label="CPF"
                                   onChange={(e) => setDocument(e.target.value)}
                            />
                        </div>

                        <div className="flex w-full flex-wrap items-end md:flex-nowrap mb-6 md:mb-0 gap-4">
                            <Input type="email"
                                   value={email}
                                   description={!email ? "* Campo obrigatório" : ""}
                                   label="Email"
                                   onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>

                        <div className="flex w-full flex-wrap items-end md:flex-nowrap mb-6 md:mb-0 gap-4">
                            <Input type="password"
                                   value={password}
                                   description={!password ? "* Campo obrigatório" : ""}
                                   label="Senha"
                                   onChange={(e) => setPassword(e.target.value)}
                            />
                        </div>

                        <Button className={"bg-orange-600 text-white w-full  font-bold"} onClick={onSubmit}>
                            Cadastrar
                        </Button>
                        <p className={"text-gray-500 font-semibold"}>Já possui conta? <a href={"/login"} className={"underline text-gray-600 font-bold"}>Faça Login!</a>
                        </p>
                        <Divider/>
                    </form>
                    <div className={"flex items-center justify-center w-full my-2"}>
                        {
                            loading && <Spinner/>
                        }
                    </div>
                </div>

            </div>

        </div>

    );
}

export default CriarConta;