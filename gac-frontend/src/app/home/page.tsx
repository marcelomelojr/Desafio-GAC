import {walletService} from "@/services/walletService";
import {formatarMoeda} from "@/utils/formatarValorMonetario";
import CreateTransaction from "@/components/Wallet/CreateTransaction";
import HistoryTransactions from "@/components/Transactions/HistoryTransactions";
import {Wallet, Cardholder} from "@phosphor-icons/react/dist/ssr";
import HistoryDeposits from "@/components/Transactions/HistoryDeposits";
import {getSession} from "@/utils/getSession";

const Home = async () => {

    const session = await getSession()

    const balance = await walletService.getBalance();
    const transactions = await walletService.getAllTransactions();
    const deposits = await walletService.getAllDeposits();

    return (
        <div className={"max-w-4xl mx-auto"}>
            <section className={"flex items-center justify-between gap-x-20"}>
                <div className={"flex max-w-lg px-8 py-10 shadow min-h-[230px]"}>
                    <div className={"w-60"}>
                        <Cardholder size={128} weight="bold"/>
                    </div>

                    <div className={"self-end flex flex-col justify-self-end w-full items-end justify-end"}>
                        <p className={"text-4xl font-semibold text-green-400"}>
                            {formatarMoeda(balance)}
                        </p>
                        <p>Meu Saldo</p>
                    </div>
                </div>

                <CreateTransaction/>

            </section>
            <section className={"flex max-w-4xl mx-auto items-center justify-center mt-6 py-8 gap-x-20 border shadow"}>
                <HistoryTransactions transactions={transactions}/>
            </section>

            <section className={"flex max-w-4xl mx-auto items-center justify-center mt-6 py-8 gap-x-20 border shadow"}>
                <HistoryDeposits deposits={deposits}/>
            </section>
        </div>

    )
}

export default Home;