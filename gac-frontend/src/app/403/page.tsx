import Link from "next/link";

const Page403 = () => {
    return (

        <section className="flex justify-center items-center h-screen bg-gray-100 p-6">
            <div className="bg-white p-6 rounded-lg shadow-md text-center w-full max-w-md">
                <h1 className="text-4xl font-bold text-red-600">403</h1>
                <h2 className="text-2xl font-semibold mt-2">Acesso Negado</h2>
                <p className="mt-4 text-gray-600">Você não tem permissão para acessar esta página.</p>
                <Link className="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                      href="/home">Voltar para Home</Link>

            </div>
        </section>
    )
}

export default Page403;