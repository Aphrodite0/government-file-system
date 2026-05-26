# Government File Management System

A comprehensive Laravel-based file management system designed for government offices to securely send, receive, and track documents online.

## Features

- 🔐 **Secure Office Login** - Each office has their own login account
- 👨‍💼 **Admin Dashboard** - Monitor all offices and system activities
- 📤 **File Upload & Transfer** - Send documents to other offices
- 📊 **Real-time Monitoring** - Live indications of system activity
- 📍 **Document Tracking** - Track who sent, received, time, and date
- 🔍 **Search Feature** - Search documents and track history
- 📱 **Responsive Design** - Works on desktop and mobile devices

## System Architecture

```
government-file-system/
├── app/
│   ├── Models/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Events/
│   ├── Listeners/
│   └── Jobs/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── storage/
└── tests/
```

## Installation & Setup

### Prerequisites
- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js & npm

### Step 1: Clone & Install
```bash
git clone https://github.com/Aphrodite0/government-file-system.git
cd government-file-system
composer install
npm install
```

### Step 2: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Database Configuration
Edit `.env` file with your database credentials:
```
DB_DATABASE=government_file_system
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Step 4: Create Database
```bash
mysql -u root -p
CREATE DATABASE government_file_system;
EXIT;
```

### Step 5: Run Migrations
```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Build Assets
```bash
npm run dev
# or for production
npm run build
```

### Step 7: Start Local Server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## Default Login Credentials

### Admin Account
- **Email:** admin@government.test
- **Password:** password123

### Sample Office Account
- **Email:** office1@government.test
- **Password:** password123

## Project Structure

### Models
- **User** - Handles authentication (Admin & Office users)
- **Office** - Stores office information
- **Document** - File/document records
- **Transfer** - Document transfer tracking
- **ActivityLog** - Track all system activities

### Controllers
- **AuthController** - Login/Logout functionality
- **DashboardController** - Dashboard displays
- **DocumentController** - File upload and management
- **TransferController** - Document transfers
- **AdminController** - Admin monitoring
- **SearchController** - Document search

### Views
- auth/ - Login pages
- dashboard/ - Main dashboard
- documents/ - Document management
- transfers/ - Transfer tracking
- admin/ - Admin panel

## Database Schema

### users table
- id, name, email, password, role (admin/office), office_id, created_at, updated_at

### offices table
- id, office_name, office_code, department, email, phone, address, created_at, updated_at

### documents table
- id, office_id, filename, original_name, file_path, file_size, file_type, description, created_at, updated_at

### transfers table
- id, document_id, from_office_id, to_office_id, status, sent_at, received_at, read_at, notes, created_at, updated_at

### activity_logs table
- id, user_id, action, description, ip_address, created_at

## Key Features Explained

### Real-time Monitoring
- Uses Laravel Events and Listeners
- Broadcasting with Pusher (optional)
- Live activity updates on admin dashboard

### Document Tracking
- Complete audit trail of all documents
- Track who sent, received, and when
- Transfer status monitoring

### Search Functionality
- Search by filename, office name, date range
- Filter by transfer status
- Advanced search with multiple criteria

## Testing

### Run Tests
```bash
php artisan test
```

### Test Coverage
- Authentication tests
- Document upload tests
- Transfer tracking tests
- Authorization tests

## Deployment to Vercel

### Prepare for Vercel
1. Create `vercel.json` configuration
2. Set up database on cloud (Planetscale, AWS RDS, etc.)
3. Configure storage for file uploads (S3, Azure, etc.)

### Deploy
```bash
vercel deploy
```

## Important Notes

### File Storage
- Local testing: Files stored in `storage/app/public/uploads`
- Production: Configure S3 or other cloud storage

### Database
- Local: MySQL on localhost
- Production: Use managed database service

### Environment Variables
- Never commit `.env` file
- Set environment variables in Vercel dashboard

## Troubleshooting

### "Connection refused" error
- Ensure MySQL is running
- Check database credentials in `.env`

### "Class not found" error
- Run `composer dump-autoload`

### File upload not working
- Check `storage/app/public` permissions: `chmod 755`
- Verify `FILE_UPLOAD_PATH` in `.env`

### Real-time updates not working
- Pusher requires valid credentials
- Or use polling as fallback

## Security Features

- ✅ CSRF Protection
- ✅ SQL Injection Prevention
- ✅ Password Encryption (bcrypt)
- ✅ Role-based Access Control
- ✅ Activity Logging
- ✅ Secure File Uploads
- ✅ Rate Limiting

## Support & Documentation

For detailed API documentation and advanced configuration, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [System API Guide](./API.md) (Coming soon)

## License

MIT License - see LICENSE file for details

## Author

Created for Government Offices File Management

---

**Status:** Development Phase
**Last Updated:** 2026-05-26
**Version:** 1.0.0
