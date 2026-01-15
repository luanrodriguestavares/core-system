# SaaS Core - Arquitetura e Esqueleto Inicial

## Estrutura de pastas (backend e frontend)

```
core-system/
├── core-api/
│   ├── app/
│   │   ├── Billing/
│   │   │   ├── BillingManager.php
│   │   │   └── Gateways/
│   │   │       ├── BillingGatewayInterface.php
│   │   │       ├── MercadoPagoGateway.php
│   │   │       └── NullGateway.php
│   │   ├── Console/Commands/
│   │   │   ├── TenantsCreateCommand.php
│   │   │   └── TenantsMigrateCommand.php
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── App/
│   │   │   │   │   ├── AppointmentsController.php
│   │   │   │   │   ├── CustomersController.php
│   │   │   │   │   └── TransactionsController.php
│   │   │   │   └── Billing/WebhookController.php
│   │   │   └── Middleware/
│   │   │       ├── EnsureTenantIsActiveMiddleware.php
│   │   │       └── TenantResolverMiddleware.php
│   │   ├── Models/
│   │   │   ├── Master/
│   │   │   │   ├── Invoice.php
│   │   │   │   ├── MasterUser.php
│   │   │   │   ├── Plan.php
│   │   │   │   ├── Subscription.php
│   │   │   │   ├── Tenant.php
│   │   │   │   └── WebhookEvent.php
│   │   │   └── Tenant/
│   │   │       ├── TenantModel.php
│   │   │       └── TenantUser.php
│   │   ├── Policies/
│   │   │   ├── MasterPolicy.php
│   │   │   └── TenantPolicy.php
│   │   └── Services/
│   │       └── TenantConnectionService.php
│   ├── config/billing.php
│   ├── database/migrations/
│   │   ├── master/...
│   │   └── tenant/...
│   ├── routes/api.php
│   └── docs/ARCHITECTURE.md
└── core-web/
    ├── package.json
    ├── vite.config.js
    └── src/
        ├── api/client.js
        ├── apps/
        │   ├── master/
        │   │   ├── MasterApp.jsx
        │   │   └── pages/
        │   │       ├── Login.jsx
        │   │       ├── Plans.jsx
        │   │       ├── TenantBilling.jsx
        │   │       └── Tenants.jsx
        │   └── tenant/
        │       ├── TenantApp.jsx
        │       └── pages/
        │           ├── Appointments.jsx
        │           ├── Customers.jsx
        │           ├── Dashboard.jsx
        │           ├── Login.jsx
        │           ├── Settings.jsx
        │           └── Transactions.jsx
        ├── components/Layout.jsx
        ├── main.jsx
        └── router/index.jsx
```

## Fluxos críticos

### Resolução de tenant (request /api/app)
1. `TenantResolverMiddleware` resolve slug por subdomínio ou `X-Tenant`.
2. Busca tenant no DB master.
3. Configura conexão `tenant` dinamicamente.
4. Seta conexão default e injeta tenant no container.

### Uploads isolados
- Padrão: `storage/app/tenants/{tenant_id}/...`
- Download via controller que valida tenant ativo e ownership.

### Billing e webhooks
- `BillingManager` resolve gateway por `config('billing.gateway')`.
- `WebhookController` registra evento com idempotência em `webhook_events`.
- Job diário: `php artisan billing:sync` (futuro) para reconciliação.

## Exemplos de requests/responses (JSON)

### Login Master
**POST** `/api/master/auth/login`
```json
{
  "email": "admin@saas.com",
  "password": "secret"
}
```
**Response**
```json
{
  "token": "master-token"
}
```

### Criar Tenant
**POST** `/api/master/tenants`
```json
{
  "name": "Clínica Alfa",
  "slug": "clinica-alfa",
  "domain": "clinica-alfa.seudominio.com",
  "plan_id": 1
}
```
**Response**
```json
{
  "data": {
    "id": 10,
    "name": "Clínica Alfa",
    "slug": "clinica-alfa",
    "status": "active"
  }
}
```

### Iniciar assinatura
**POST** `/api/master/subscriptions/10/start`
```json
{
  "plan_id": 2,
  "payment_method": {
    "token": "tok_visa_123"
  }
}
```
**Response**
```json
{
  "data": {
    "subscription_id": 300,
    "status": "active"
  }
}
```

### Login Tenant
**POST** `/api/app/auth/login`
```json
{
  "email": "admin@tenant.local",
  "password": "ChangeMe123!"
}
```
**Response**
```json
{
  "token": "tenant-token"
}
```

## Checklist MVP (2 semanas)

### Semana 1
- [ ] Setup Laravel 11 API-only + Sanctum.
- [ ] Configurar conexão `master` e `tenant` no `.env`.
- [ ] Implementar `TenantResolverMiddleware` + `TenantConnectionService`.
- [ ] Migrar tabelas master + tenant.
- [ ] Implementar comandos `tenants:create` e `tenants:migrate`.
- [ ] CRUD básico em `/api/app` (customers/appointments/transactions).

### Semana 2
- [ ] Implementar painel master (`/master`) com login e lista de tenants.
- [ ] Implementar gateway stub + webhook idempotente.
- [ ] Implementar middleware `EnsureTenantIsActive`.
- [ ] Implementar roteamento `/app` com login + dashboard.
- [ ] Configurar rate limit por tenant.
- [ ] Documentar provisionamento e fluxo de billing.
