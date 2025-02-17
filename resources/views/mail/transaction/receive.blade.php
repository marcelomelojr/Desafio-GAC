<x-mail::message>
# ✅ Comprovante de Recibo de Transferência

Olá,
A transferência de fundos foi concluída com sucesso. Seguem os detalhes da transação:

## 💰Detalhes da Transferência

- **Realizado por:** {{$transaction['payer']}}
- **Destinatário:** {{$transaction['payee']}}
- **Valor Transferido:** R$ {{ number_format($transaction['amount'] / 100, 2, ',', '.') }}
- **Data da Transação:** {{$transaction['created_at']}}
---

Atenciosamente
</x-mail::message>
