<x-mail::message>
# ✅ Comprovante de Envio de Transferência

Olá,
A transação foi realizada com sucesso. Seguem os detalhes do envio:
---

## 💰 Detalhes da Transação

- **Destinatário:** {{$transaction['payee']}}
- **Valor Transferido:** R$ {{$transaction['amount']}}
- **Data da Transação:** {{$transaction['created_at'] }}
---

## 📄 Status da Transação

✔ **Transação Confirmada**

Este e-mail é uma confirmação oficial da transação realizada.
</x-mail::message>
