import {adminService} from "@/services/adminService";
import {formatarMoeda} from "@/utils/formatarValorMonetario";
import {formatarDataHora} from "@/utils/dateUtils";
import RollbackActions from "@/components/Admin/RollbackActions";

const Admin = async () => {
    const transactionsRollbacks = await adminService.getTransactionsRollbacks();

    return (
        <div className="bg-white p-6 rounded-lg w-full">
            <h2 className="text-2xl font-bold">Solicitações de Cancelamento de Transferências</h2>
            <p className={"mt-0 mb-4"}>Analise as solicitações pendentes</p>

            <table className="w-full border-collapse border border-gray-300 text-left">
                <thead className="bg-gray-200">
                <tr>
                    <th className="p-3 border border-gray-300">#</th>
                    <th className="p-3 border border-gray-300">Pagador</th>
                    <th className="p-3 border border-gray-300">Recebedor</th>
                    <th className="p-3 border border-gray-300">Valor (R$)</th>
                    <th className="p-3 border border-gray-300">Data da Transferência</th>
                    <th className="p-3 border border-gray-300">Data da Solicitação</th>
                    <th className="p-3 border border-gray-300">Ações</th>
                </tr>
                </thead>
                <tbody>
                { transactionsRollbacks && transactionsRollbacks?.map((transaction, index) => (
                    <tr key={index} className="bg-white hover:bg-gray-100">
                        <td className="p-3 border border-gray-300">{ transaction?.id }</td>
                        <td className="p-3 border border-gray-300">{ transaction?.payer?.name}</td>
                        <td className="p-3 border border-gray-300">{ transaction?.payee?.name}</td>
                        <td className="p-3 border border-gray-300 text-green-600 font-bold">{formatarMoeda(transaction?.transaction?.amount/100)}</td>
                        <td className="p-3 border border-gray-300">{ formatarDataHora(transaction?.transaction?.created_at)}</td>
                        <td className="p-3 border border-gray-300">{ formatarDataHora(transaction?.created_at)}</td>
                        <td className="p-3 border border-gray-300 flex gap-2">
                            <RollbackActions id={transaction?.transaction?.id} />
                        </td>
                    </tr>
                ))}

                </tbody>
            </table>


        </div>
    )
}

export default Admin