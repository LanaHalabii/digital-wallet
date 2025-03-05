# Digital Wallet

# 1. Component Diagram
![Untitled Diagram drawio](https://github.com/user-attachments/assets/bf86bcee-a6f6-49f2-82cc-aa1baf43b11a)

# 2. ER Diagram 
- admin_users ( **admin_id**, email, password_hash, role )
- analytics ( **analytic_id**, date, transaction_volume )
- backups ( **backup_id**, backup_time, backup_status )
- history_transactions ( **transaction_id**, user_id, transaction_type, transaction_date )
- identity_verifications ( **verification_id**, user_id, document_type, document_file, verification_date, verification_status )
- internal_transfers ( **transfer_id**, user_id, receiver_id, amount, transfer_status, transfer_date )
- qr_transactions ( **qr_id**, transaction_id, qr_data, date )
- scheduled_payments ( **payment_id**, user_id, wallet_id, amount, payment_type, scheduled, start_date, status )
- social_logins ( **social_login_id**, user_id, provider )
- system_logs ( **log_id**, action, user_id, date )
- tickets ( **ticket_id**, user_id, subject, description, ticket_date )
- ticket_responses ( **response_id**, ticket_id, admin_id, response )
- transactions ( **transaction_id**, wallet_id, amount, transaction_type, transaction_status, created_at )
- transaction_limits ( **limit_id**, user_id, daily_limit, weekly_limit, monthly_limit )
- users ( **user_id**, full_name, username, email, phone_number, password_hash, user_address, created_at, updated_at, verification_type, verification_status, transaction_limit )
- user_notifications ( **notification_id**, user_id, message, is_read )
- wallets ( **wallet_id**, user_id, balance, currency, created_at, updated_at )

  # Relational Database
**1. Users & Wallets : 1-to-many** <br>
Each user can have many wallet, and each wallet belongs to one user <br>
**2. Users & User notifications : 1-to-many** <br>
Each user can have many notifications, and each notification belongs to one user <br>
**3. Users & Transactions : 1-to-many** <br>
Each user can have many transactions, and each transaction belongs to one user <br>
**4. Users & Transaction limits : 1-to-1** <br>
Each user has one transaction limit, and each transaction limit belongs to one user <br>
**5. Users & Tickets : 1-to-many** <br>
Each user can have many tickets, and each ticket belongs to one user <br>
**6. Admin & Ticket responses : 1-to-many** <br>
Each admin can respond to many tickets, and each ticket is responded to by one admin <br>
**7. User & System Logs : 1-to-1** <br>
Each user has one system log, and each system log belongs to one user <br>
**8. Users & Social logins : 1-to-1** <br>
Each user has one social login, and each social login belongs to one user <br>
**9. Users & Scheduled payments : 1-to-many** <br>
Each user can create many shceduled payments, and each scheduled payment belongs to one user <br>
**10. Users & QR transactions : 1-to-many** <br>
Each user can create many QR transactions, and each QR transaction belongs to one user <br>
**11. Users & Internal transfers : 1-to-many** <br>
Each user can have many internal transfer, and each internal transfer belongs to one user <br>
**12. Users & Identity verification : 1-to-1** <br>
Each user has one identity verification, and each indentity verification belongs to one user <br>
**13. Users & transaction history : 1-to-1** <br>
Each user has one transaction history, and each transaction history belongs to one user <br>
**14. Users & Analytics : 1-to-many** <br>
Each user has many analytics, and each analytic belongs to one user <br>

# 3. API Documentation
For this project, we could include the API that belongs to Stripe. It's use case is for payment processing: It basically could help in setting up payment methods, handling recurring payments and implementing webhook for payment notifications. <br>
Stripe access & interpretation into project : https://docs.stripe.com/get-started/development-environment 

# 4. Hosting Details 
# IP
http://13.38.76.3/wallet-server/
# Github Pages
https://lanahalabii.github.io/
