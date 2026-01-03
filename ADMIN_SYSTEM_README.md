# LCR Booking - Admin System

## 🎉 Superadmin and Admin System Successfully Created!

Ang system ay may 3 levels ng users:
- **User** - Regular users
- **Admin** - May access sa admin panel at user management
- **Superadmin** - Full control, pwedeng gumawa ng ibang superadmin

---

## 📧 Default Login Credentials

### Super Admin (Tine)
- **Email:** tine@lcr.com
- **Password:** 12345

### Admin (Mae)
- **Email:** mae@lcr.com
- **Password:** 54321

### Regular User
- **Email:** user@lcr.com
- **Password:** user123

---

## 🚀 How to Access Admin Panel

1. **Login using admin or superadmin credentials**
2. **Click your profile dropdown** (upper right corner)
3. **Click "Admin Panel"** (gold link sa menu)
4. **Navigate to Dashboard or User Management**

---

## ✨ Admin Panel Features

### Dashboard
- View total users statistics
- View total admins count
- View total superadmins count
- See recent user registrations

### User Management
- ✅ **View all users** - See complete list with pagination
- ✅ **Create users** - Add new users with specific roles
- ✅ **Edit users** - Update user information and roles
- ✅ **Delete users** - Remove users (cannot delete yourself)
- ✅ **Role management** - Assign user, admin, or superadmin roles
- ✅ **Password management** - Set or update user passwords

---

## 🔐 Security Features

### Role-Based Permissions
- Only **admin** and **superadmin** can access admin panel
- Only **superadmin** can create/edit/delete other superadmins
- Users cannot delete themselves
- Automatic role validation on all operations

### Middleware Protection
All admin routes are protected with:
```php
Route::middleware(['auth', 'role:admin,superadmin'])
```

---

## 🎨 Design Features

- **Modern gradient UI** - Beautiful blue, purple, and amber gradients
- **Responsive design** - Works on all devices
- **Smooth animations** - Professional transitions and hover effects
- **Role badges** - Color-coded badges for each user role
- **Interactive tables** - Hover effects and clean layouts
- **Alert messages** - Success, error, and validation feedback

---

## 📁 Files Created/Modified

### Migrations
- `database/migrations/2025_12_29_153123_add_role_to_users_table.php`

### Models
- `app/Models/User.php` (updated with role methods)

### Middleware
- `app/Http/Middleware/CheckRole.php`
- `bootstrap/app.php` (registered middleware)

### Controllers
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/UserManagementController.php`

### Views
- `resources/views/layouts/admin.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/users/index.blade.php`
- `resources/views/admin/users/create.blade.php`
- `resources/views/admin/users/edit.blade.php`
- `resources/views/layouts/app.blade.php` (updated navigation)

### Routes
- `routes/web.php` (added admin routes)

### Seeders
- `database/seeders/SuperAdminSeeder.php`

---

## 🎯 Admin Routes

```
GET  /admin/dashboard          - Admin Dashboard
GET  /admin/users              - List all users
GET  /admin/users/create       - Create user form
POST /admin/users              - Store new user
GET  /admin/users/{id}/edit    - Edit user form
PUT  /admin/users/{id}         - Update user
DELETE /admin/users/{id}       - Delete user
```

---

## 💡 User Model Helper Methods

```php
// Check if user is superadmin
$user->isSuperAdmin()

// Check if user is admin
$user->isAdmin()

// Check if user is admin or superadmin
$user->isAdminOrAbove()
```

---

## 🔧 How to Create More Admins

### Method 1: Via Admin Panel (Recommended)
1. Login as superadmin
2. Go to Admin Panel → Users
3. Click "Add New User"
4. Fill in details and select role
5. Click "Create User"

### Method 2: Via Tinker
```bash
php artisan tinker

User::create([
    'name' => 'Your Name',
    'email' => 'youremail@example.com',
    'password' => Hash::make('yourpassword'),
    'role' => 'superadmin', // or 'admin' or 'user'
    'email_verified_at' => now(),
]);
```

---

## 🎨 Color Coding

- **Superadmin Badge** - Amber/Orange gradient with star icon
- **Admin Badge** - Purple gradient
- **User Badge** - Blue gradient

---

## 📝 Notes

- All passwords are hashed using Laravel's Hash facade
- Email verification is automatically set for seeded users
- The role column uses ENUM type in database
- All admin views use Tailwind CSS for styling
- Middleware automatically redirects unauthorized users

---

## 🛡️ Permission Matrix

| Action | User | Admin | Superadmin |
|--------|------|-------|------------|
| Access Admin Panel | ❌ | ✅ | ✅ |
| View Users | ❌ | ✅ | ✅ |
| Create User | ❌ | ✅ | ✅ |
| Edit User | ❌ | ✅ | ✅ |
| Delete User | ❌ | ✅ | ✅ |
| Create Admin | ❌ | ✅ | ✅ |
| Create Superadmin | ❌ | ❌ | ✅ |
| Edit Superadmin | ❌ | ❌ | ✅ |
| Delete Superadmin | ❌ | ❌ | ✅ |

---

**Created with ❤️ for LCR Booking System**
