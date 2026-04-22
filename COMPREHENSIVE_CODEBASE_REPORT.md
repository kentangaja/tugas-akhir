# Laravel Codebase Comprehensive Exploration Report
**Project:** verte-maison (Urban Plant Monitoring System)  
**Date:** April 13, 2026

---

## 1. CURRENT AUTHENTICATION SETUP

### 1.1 Authentication Flow
- **Guard Type:** Session-based (configured in `config/auth.php`)
- **User Provider:** Eloquent (uses `App\Models\User`)
- **Default Guard:** `web`
- **Routes Protected By:** `auth` middleware for authenticated routes, `guest` middleware for public auth routes

### 1.2 Authentication Routes (`routes/auth.php`)
The authentication routes are organized using Laravel Breeze pattern:

**Guest Routes (Unauthenticated users only):**
- `GET /register` → `RegisteredUserController@create` - Show registration form
- `POST /register` → `RegisteredUserController@store` - Store new user
- `GET /login` → `AuthenticatedSessionController@create` - Show login form
- `POST /login` → `AuthenticatedSessionController@store` - Authenticate user
- `GET /forgot-password` → `PasswordResetLinkController@create` - Show forgot password form
- `POST /forgot-password` → `PasswordResetLinkController@store` - Send reset link
- `GET /reset-password/{token}` → `NewPasswordController@create` - Show reset form
- `POST /reset-password` → `NewPasswordController@store` - Complete password reset

**Authenticated Routes:**
- `GET /verify-email` → `EmailVerificationPromptController` - Email verification notice
- `GET /verify-email/{id}/{hash}` → `VerifyEmailController` - Verify email (signed route)
- `POST /email/verification-notification` → `EmailVerificationNotificationController@store` - Resend verification
- `GET /confirm-password` → `ConfirmablePasswordController@show` - Confirm password page

### 1.3 Authentication Controllers (`app/Http/Controllers/Auth/`)
- `AuthenticatedSessionController.php` - Handles login/logout
- `RegisteredUserController.php` - Handles user registration
- `PasswordResetLinkController.php` - Initiates password reset
- `NewPasswordController.php` - Completes password reset
- `PasswordController.php` - Updates user password
- `EmailVerificationPromptController.php` - Shows email verification notice
- `VerifyEmailController.php` - Handles email verification
- `EmailVerificationNotificationController.php` - Resends verification email
- `ConfirmablePasswordController.php` - Confirms password before sensitive operations

### 1.4 Public Web Routes (`routes/web.php`)
- `GET /` → Displays home view (no auth required)
- `GET /menu` → Menu page
- `GET /tutorial` → Tutorial page

**Protected Device Routes (require `auth` middleware):**
- `GET /devices` → `DeviceController@index` - List user devices
- `GET /devices/{device}` → `DeviceController@show` - Show single device with data
- `GET /devices/{device}/code` → `DeviceController@code` - Display device code
- `GET /devices/{device}/latest-data` → `DeviceController@getLatestData` - Get latest sensor readings

**Protected Profile Routes:**
- `GET /profile` → `ProfileController@edit` - Edit profile form
- `PATCH /profile` → `ProfileController@update` - Update profile
- `DELETE /profile` → `ProfileController@destroy` - Delete account

---

## 2. NAVBAR/LAYOUT STRUCTURE

### 2.1 Layout System
The app uses two main layout components:

#### **App Layout** (`resources/views/layouts/app.blade.php`)
- Used for authenticated pages
- Includes navigation bar and optional header section
- Dark mode support with transition effects
- Includes Chart.js library for data visualization
- Min-height screen wrapper with proper spacing
- Loading spinner implemented with Alpine.js

#### **Guest Layout** (`resources/views/layouts/guest.blade.php`)
- Used for authentication pages (login, register, password reset)
- Centered card design
- Dark mode support
- No navbar, minimal styling
- CSRF token included

### 2.2 Navbar Component (`resources/views/layouts/navigation.blade.php`)

#### **Structure:**
- **Sticky positioning** with z-index 50
- **Dark mode support** throughout
- **Responsive design** with desktop/mobile toggle

#### **Desktop Layout (≥768px):**
- **Logo:** "verte-maison" (links to home)
- **Navigation Links** (with icons):
  - Home (house icon)
  - Tutorial (wrench icon)
  - Devices (mobile phone icon)
- **Authentication Section:**
  - For authenticated users: Dropdown menu with user name, Profile link, and Logout
  - For guests: Login and Register links

#### **Mobile Layout (<768px):**
- Hamburger menu button (toggles with Alpine.js `x-data="{ open: false }"`)
- Collapsible dropdown showing:
  - Home link
  - User information (if authenticated)
  - Theme toggle button
  - Profile/Logout or Login links

#### **Theme Toggle Button:**
- Available on mobile in the collapsed menu
- Displays moon/sun emoji (🌓)
- Persistent across page reloads (uses localStorage)
- Integrated with dark mode toggle function

### 2.3 Navigation Components Used
- `<x-nav-link>` - Desktop navigation links with active state
- `<x-dropdown>` - User dropdown menu (desktop)
- `<x-responsive-nav-link>` - Mobile navigation links
- `<x-dropdown-link>` - Links within dropdown menus

### 2.4 Styling
- **Colors:** Dark mode uses `dark:bg-black`, `dark:bg-gray-800`, brand color `#063b2a` (dark green)
- **Navigation bar:** White background with `dark:bg-black` for dark mode
- **Links:** Dark green hover state (#063b2a)
- **Transitions:** Smooth color transitions on hover

---

## 3. DARK MODE IMPLEMENTATION

### 3.1 Configuration
**Tailwind CSS Configuration** (`tailwind.config.js`):
```javascript
darkMode: 'class'  // Uses class-based dark mode (adds 'dark' class to html root)
```

### 3.2 Dark Mode Toggle Mechanism (`resources/views/layouts/navigation.blade.php`)

#### **JavaScript Implementation:**
```javascript
function toggleTheme()
  - Checks current theme class on document.documentElement
  - Toggles between 'light' and 'dark'
  - Stores preference in localStorage under key 'theme'
  - Updates theme icons display

function applyTheme(theme)
  - Adds or removes 'dark' class from html element
  - Updates icon visibility

// Initialization on page load:
  - Checks localStorage for saved theme
  - Falls back to system preference: window.matchMedia('(prefers-color-scheme: dark)')
  - If no preference, defaults to 'light'
```

#### **Button Location:**
- Mobile menu only: One button with moon/sun emoji (🌓)
- Appears in collapsed navigation drawer
- Styling: `bg-gray-100 dark:bg-gray-700` with responsive text colors

#### **Theme Icons:**
- IDs referenced: `#icon-sun` and `#icon-moon`
- Icons toggle visibility based on current theme
- Currently displays emoji instead of SVG icons

### 3.3 Dark Mode CSS Coverage

**App-wide elements:**
- `<body>` - `dark:bg-gray-900 dark:text-gray-100`
- Navigation - `dark:bg-black dark:text-white`
- Headers - `dark:bg-gray-800`
- Landing page - `dark:bg-zinc-950`
- Forms and inputs - `dark:bg-gray-900 dark:border-gray-700`

**Tutorial page dark mode:**
- Section backgrounds: `dark:bg-zinc-900`, `dark:bg-emerald-900`
- Text colors: `dark:text-white`, `dark:text-emerald-400`
- Borders: `dark:border-emerald-400/30`

**Auth pages dark mode:**
- Background: `dark:bg-gray-800`
- Text: `dark:text-gray-400`, `dark:text-gray-100`
- Inputs: `dark:bg-gray-900 dark:border-gray-700`
- Focus states: `dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800`

### 3.4 Missing Elements
- ⚠️ No dark mode toggle on desktop navbar (only on mobile)
- ⚠️ No sun/moon SVG icons (only emoji)
- ⚠️ Theme preference not synced across browser tabs
- ⚠️ No persistent theme indicator in navigation on desktop

---

## 4. USER MODEL AND AUTHENTICATION TABLE STRUCTURE

### 4.1 User Model (`app/Models/User.php`)

#### **Model Definition:**
```php
Class: App\Models\User extends Authenticatable
Traits: HasApiTokens, HasFactory, Notifiable
```

#### **Mass Assignable Fields:**
- `name` - User's display name (string)
- `email` - User's email address (string, unique)
- `password` - Encrypted password (string)

#### **Hidden Attributes** (not included in JSON serialization):
- `password` - Hashed password
- `remember_token` - Session remember token

#### **Attribute Casts:**
- `email_verified_at` → datetime
- `password` → hashed (automatically hashed)

#### **Relationships:**
- `devices()` - One-to-many relationship with Device model
  - User can have multiple devices
  - Devices linked via `user_id` foreign key

#### **Capabilities:**
- API token support via `HasApiTokens` (Laravel Sanctum)
- Notifications support via `Notifiable`
- Factory support for testing via `HasFactory`

### 4.2 Users Table Schema (`database/migrations/0001_01_01_000000_create_users_table.php`)

```sql
CREATE TABLE users (
    id              BIGINT PRIMARY KEY AUTO_INCREMENT
    name            VARCHAR(255) NOT NULL
    email           VARCHAR(255) NOT NULL UNIQUE
    email_verified_at TIMESTAMP NULL
    password        VARCHAR(255) NOT NULL
    remember_token  VARCHAR(100) NULL
    created_at      TIMESTAMP NULL
    updated_at      TIMESTAMP NULL
)

CREATE TABLE password_reset_tokens (
    email           VARCHAR(255) PRIMARY KEY
    token           VARCHAR(255) NOT NULL
    created_at      TIMESTAMP NULL
)

CREATE TABLE sessions (
    id              VARCHAR(255) PRIMARY KEY
    user_id         BIGINT NULL (indexed)
    ip_address      VARCHAR(45) NULL
    user_agent      TEXT NULL
    payload         LONGTEXT NOT NULL
    last_activity   INT NOT NULL (indexed)
    FOREIGN KEY (user_id) REFERENCES users(id)
)
```

### 4.3 User Factory (`database/factories/UserFactory.php`)
- Used for testing/seeding
- Can generate test users with factory pattern
- Follows Laravel Breeze standard factory

### 4.4 Authentication Features
- **Email Verification:** Supported (email_verified_at timestamp)
- **Password Reset:** Supported (password_reset_tokens table)
- **Session Management:** Tracked in sessions table
- **Remember Me:** Supported via remember_token
- **API Tokens:** Supported via Laravel Sanctum

---

## 5. RELATED MODELS

### 5.1 Device Model (`app/Models/Device.php`)
**Purpose:** Represents IoT devices for plant monitoring

**Mass Assignable Fields:**
- `user_id` - Foreign key to User
- `device_name` - String identifier for device
- `api_key` - API key for device communication
- `fan_threshold` - Float value for fan trigger
- `soil_threshold` - Integer value for soil moisture trigger

**Relationships:**
- `user()` - Belongs to User
- `sensorData()` - Has many SensorData records

**Casting:**
- `fan_threshold` → float
- `soil_threshold` → integer
- Timestamps cast to datetime

### 5.2 SensorData Model (`app/Models/SensorData.php`)
**Purpose:** Stores sensor readings from devices

**Mass Assignable Fields:**
- `device_id` - Foreign key to Device
- `temperature` - Decimal sensor reading
- `humidity` - Decimal sensor reading
- `soil` - Decimal soil moisture reading

**Relationships:**
- `device()` - Belongs to Device

### 5.3 Device-Related Database Tables
- `devices` table - Stores device records with user_id reference
- `sensor_data` table - Stores timestamped sensor readings
  - Typically linked via `device_id` foreign key
  - Includes created_at/updated_at for time-series data

---

## 6. UI FRAMEWORK AND DEPENDENCIES

### 6.1 Frontend Framework Stack

#### **CSS Framework:**
- **Tailwind CSS** v3.4.19
- Dark mode support via class-based configuration
- Form utilities via `@tailwindcss/forms` plugin
- Additional utilities via `@tailwindcss/vite` plugin

#### **JavaScript Framework:**
- **Alpine.js** v3.4.2 - Lightweight reactive framework for navbar toggles and interactive elements
- **Axios** v1.11.0 - HTTP client for API requests
- **NProgress** v0.2.0 - Progress bar for page navigation

#### **Build Tools:**
- **Vite** v7.0.7 - Modern build tool and dev server
- **Laravel Vite Plugin** v2.0.0 - Integration with Laravel
- **Autoprefixer** v10.4.2 - CSS vendor prefixing
- **PostCSS** v8.4.31 - CSS processing

### 6.2 Dependencies Summary
```json
{
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.2",
    "@tailwindcss/vite": "^4.1.18",
    "alpinejs": "^3.4.2",
    "autoprefixer": "^10.4.2",
    "axios": "^1.11.0",
    "concurrently": "^9.0.1",
    "laravel-vite-plugin": "^2.0.0",
    "postcss": "^8.4.31",
    "tailwindcss": "^3.4.19",
    "vite": "^7.0.7"
  },
  "dependencies": {
    "nprogress": "^0.2.0"
  }
}
```

### 6.3 CSS Entry Point (`resources/css/app.css`)
- Tailwind base, components, and utilities
- Custom NProgress styling with red accent (#ff2d20)
- Custom progress bar height: 4px
- Custom spinner styling

### 6.4 JavaScript Entry Point (`resources/js/app.js`)
- Alpine.js initialization and global assignment
- NProgress configuration:
  - Minimum progress: 0.1
  - Animation easing: ease
  - Speed: 500ms
  - No spinner displayed
- Page load handlers for progress bar
- Bootstrap axios configuration from `resources/js/bootstrap.js`

### 6.5 Chart Visualization
- **Chart.js** - Included via CDN in `resources/views/layouts/app.blade.php`
- Used for displaying sensor data trends
- Available on authenticated pages for device monitoring

---

## 7. LANDING PAGE & PUBLIC Views

### 7.1 Home Page (`resources/views/home.blade.php`)
- Uses `<x-app-layout>` component
- Modern hero layout with large headline:
  - "Reimagining Urban Spaces" with green highlight box
  - "Greening the World" tagline
- Grid-based layout:
  - Left column: Team info card + action buttons
  - Right column: Hero image placeholder + info box
- Fixed footer with animated marquee showcasing features
- Custom animations (scroll animation)
- Brand colors: Green (#d4e9d4, #063b2a)
- Responsive design (mobile-first approach)

### 7.2 Tutorial Page
- Step-by-step guide with 4 main sections:
  1. "Daftar & Masuk" (Register & Login)
  2. "Rakit Perangkat" (Build Device)
  3. "Upload Program" (Upload Code)
  4. "Pantau Tanaman" (Monitor Plants)
- Technical details section with libraries:
  - ArduinoJson library reference
  - 115200 baud rate specification
- Full dark mode support
- Hover effects on cards
- Centered call-to-action

---

## 8. PROFILE MANAGEMENT

### 8.1 ProfileController (`app/Http/Controllers/ProfileController.php`)
**Methods:**
- `edit(Request $request)` - Display profile edit form
- `update(ProfileUpdateRequest $request)` - Update user information
- `destroy(Request $request)` - Delete user account

**Features:**
- Email change triggers re-verification
- Password confirmation required for account deletion
- Redirect with status flash message after update

---

## 9. DEVICE MANAGEMENT

### 9.1 DeviceController (`app/Http/Controllers/DeviceController.php`)
**Methods:**
- `index()` - List authenticated user's devices
- `show(Device $device)` - Display single device with:
  - Latest sensor data
  - 15-record history (reversed chronologically)
  - Formatted time labels (H:i format)
  - Temperature and humidity data for charts
- `code(Device $device)` - Show device setup code
- `create()` - Show device creation form
- `store(Request $request)` - Store new device with validation

**Validation Rules:**
- `device_name` - required, string, max 255 chars
- `fan_threshold` - optional, numeric
- `soil_threshold` - optional, integer

---

## 10. KEY INSIGHTS & OBSERVATIONS

### 10.1 Technology Stack Summary
- **Backend:** Laravel 11 with Breeze authentication starter kit
- **Frontend:** Tailwind CSS + Alpine.js (minimal JavaScript)
- **Database:** MySQL/MariaDB (standard Laravel migrations)
- **Build Process:** Vite for hot module reloading
- **Testing Framework:** Pest (PHP unit testing)

### 10.2 Authentication Features
- ✅ Complete user authentication system (register, login, logout)
- ✅ Email verification support
- ✅ Password reset with token-based flow
- ✅ Session-based persistence
- ✅ Remember me functionality
- ✅ API token support (Sanctum)
- ✅ Profile management

### 10.3 UI/UX Features
- ✅ Fully responsive design
- ✅ Dark mode with localStorage persistence
- ✅ Alpine.js for reactive components
- ✅ Smooth transitions and animations
- ✅ Modern Tailwind CSS styling
- ✅ Loading progress indicators

### 10.4 Areas for Enhancement
- ⚠️ Desktop dark mode toggle (currently mobile-only)
- ⚠️ Icon system refinement (using emoji vs. SVG)
- ⚠️ User preference syncing across tabs
- ⚠️ Not mobile: Hamburger menu mobile nav links (partial implementation)
- ⚠️ Additional user profile fields (avatar, bio, preferences)
- ⚠️ Two-factor authentication not implemented

### 10.5 Data Structure
- Users own multiple devices
- Devices collect multiple sensor readings over time
- Thresholds stored per device (fan, soil moisture)
- API key per device for external communication

---

## 11. ROUTING SUMMARY TABLE

| Method | Route | Controller | Auth | Purpose |
|--------|-------|-----------|------|---------|
| GET | / | - | No | Home page |
| GET | /menu | - | No | Menu page |
| GET | /tutorial | - | No | Tutorial page |
| GET | /register | RegisteredUserController@create | guest | Registration form |
| POST | /register | RegisteredUserController@store | guest | Create user |
| GET | /login | AuthenticatedSessionController@create | guest | Login form |
| POST | /login | AuthenticatedSessionController@store | guest | Authenticate |
| POST | /logout | AuthenticatedSessionController@destroy | auth | Logout |
| GET | /devices | DeviceController@index | auth | List devices |
| GET | /devices/{id} | DeviceController@show | auth | Device details |
| GET | /devices/{id}/code | DeviceController@code | auth | Setup code |
| GET | /devices/{id}/latest-data | DeviceController@getLatestData | auth | Latest readings |
| GET | /profile | ProfileController@edit | auth | Edit profile |
| PATCH | /profile | ProfileController@update | auth | Update profile |
| DELETE | /profile | ProfileController@destroy | auth | Delete account |

---

## CONCLUSION

This Laravel application implements a complete IoT plant monitoring system with:
- **Robust authentication** using Laravel Breeze
- **Modern responsive UI** with Tailwind CSS
- **Dark mode support** with user preferences
- **Device management** for IoT sensors
- **Sensor data visualization** with Chart.js
- **Clean architecture** following Laravel conventions

The codebase is well-structured for a monitoring application with clear separation of concerns between authentication, device management, and data visualization layers.
