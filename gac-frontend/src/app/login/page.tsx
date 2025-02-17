'use client'

import React, {useState} from "react";
import {Input} from "@nextui-org/input";
import {Button, Divider} from "@nextui-org/react";
import { signIn } from '@/utils/signIn'
import { useRouter } from 'next/navigation'
import MyLogo from "@/assets/icons/MyLogo";
import {Spinner} from "@nextui-org/spinner";
import {notifyCustom} from "@/utils/Notify";

const Login = () => {

    const router = useRouter();

    const [loading, setLoading] = useState(false)
    const [invalidCredentials, setInvalidCredentials] = useState(false)


    const [email, setEmail] = useState('test@example.com')
    const [password, setPassword] = useState('12345678')

    const onSubmit = async () => {
        try {
            setLoading(true)
            setInvalidCredentials(false)
            const response = await signIn({
                email,
                password
            })

            if (response?.status === 401) throw new Error('Invalid credentials')

            router.push('/home')
            window.location.href = '/home'
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
                    <h1 className={"text-2xl text-gray-600 font-bold"}>Entre</h1>
                    <h2 className={"text-sm text-gray-300"}>Faça o login para ter acesso a sua carteira</h2>
                </div>
                <div className={"container"}>
                    {
                        invalidCredentials &&
                        <p className={"self-center text-red-500 font-semibold"}>Credenciais inválidas</p>
                    }
                    <form className={"flex flex-col items-center justify-center w-full space-y-4"}>

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
                            Entrar
                        </Button>
                        <p className={"text-gray-500 font-semibold"}>Não possui conta? <a href={"/criar-conta"} className={"underline text-gray-600 font-bold"}>Crie já a sua!</a>
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

export default Login;