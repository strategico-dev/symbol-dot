# Symbol Dot CRM
## API Documentaion
### Users 
Registration a new user
```
POST /api/v1/users
```
### Auth
```
POST /api/v1/auth/login
```
```
GET /api/v1/auth/me
```
```
POST /api/v1/auth/refresh
```
```
POST /api/v1/auth/logout
```
### Contacts
```
GET /api/v1/contacts
```
```
POST /api/v1/contacts
```
```
GET /api/v1/contacts/{contact}
```
```
PUT /api/v1/contacts/{contact}
```
```
DELETE /api/v1/contacts/{contact}
```
### Companies
```
GET /api/v1/companies
```
```
POST /api/v1/companies
```
```
GET /api/v1/companies/{company}
```
```
PUT /api/v1/companies/{company}
```
```
DELETE /api/v1/companies/{company}
```
### Employees
```
GET /api/v1/companies/{company}/employees
```
```
POST /api/v1/companies/{company}/employees
```
```
DELETE /api/v1/companies/{company}/employees/{employee}
```
### Sales funnels
```
GET /api/v1/sales-funnels
```
```
POST /api/v1/sales-funnels
```
```
GET /api/v1/sales-funnels/{sales-funnel}
```
```
DELETE /api/v1/sales-funnels/{sales-funnel}
```
### Sales stages
```
GET /api/v1/sales-funnels/{sales-funnel}/sales-stages
```
```
POST /api/v1/sales-funnels/{sales-funnel}/sales-stages
```
```
PUT /api/v1/sales-funnels/{sales-funnel}/sales-stages/swapper
```
```
DELETE /api/v1/sales-funnels/{sales-funnel}/sales-stages/{sales-stage}
```
### Contact in sales funnel
```
POST /api/v1/sales-funnels/{sales-funnel}/sales-stages/contacts/{contact}
```
```
PUT /api/v1/sales-funnels/{sales-funnel}/sales-stages/contacts/{contact}/mover
```
```
DELETE /api/v1/sales-funnels/{sales-funnel}/sales-stages/contacts/{contact}
```
