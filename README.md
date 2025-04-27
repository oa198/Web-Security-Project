# University Management System

## Project Overview

This is a **Web Security** project developed as part of a university course, focusing on building a secure **University Management System** using **Laravel**. The system manages various university roles, authentication flows, and APIs for mobile interaction. The project emphasizes security practices, role-based access control, and collaborative development. **All team members will work on all aspects of the project** to ensure everyone gains comprehensive experience across the entire development process.

### Team Members

- Mohamed Saied
- Ahmed Essam Eldin
- Omar Ahmed Mohamed
- Mohamed Tarek Sayed

### Project Requirements

The system must include:

- **Core Functionality**: A university management system with features for managing students, faculty, and administrative tasks.
- **Roles and Permissions**:
  - At least 5 roles: **Admissions**, **DRs (Professors)**, **TAs (Teaching Assistants)**, **Students**, and **IT Support**.
  - Role-based access control using the **Spatie Laravel Permission** package.
  - A role editor for admins to define and manage roles dynamically.
- **Authentication**:
  - Login, registration, email verification, and password reset.
  - Social login support (e.g., Google, GitHub, LinkedIn) using **Laravel Socialite**.
  - Unified authentication experience with dark/light mode support.
  - Secure OAuth integration with providers following best practices.
- **Security**:
  - Hosted locally with **SSL** for secure communication.
  - Secure APIs for mobile interaction (customer-facing, i.e., for students).
- **APIs**:
  - RESTful APIs for mobile app integration, accessible only to students.
  - API documentation published on **Postman**.
- **Additional Features**:
  - To be defined as the project progresses.

### Tech Stack

- **Backend**: Laravel (PHP framework)
- **Frontend**: Blade templates (default) with optional **Vue.js** for dynamic components
- **Database**: MySQL (via XAMPP)
- **Role Management**: Spatie Laravel Permission
- **Social Login**: Laravel Socialite
- **API Documentation**: Postman
- **Local Development**: XAMPP with SSL enabled
- **Version Control**: Git (hosted on GitHub)

## Development Setup

### Prerequisites

- **XAMPP**: Ensure Apache and MySQL are installed and running.
- **PHP**: Version 8.1 or higher (compatible with Laravel 10/11).
- **Composer**: For managing PHP dependencies.
- **Node.js/NPM**: If using Vue.js for frontend components.
- **Git**: For version control.
- **Postman**: For testing and documenting APIs.

### Installation

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/Black1hp/Web-Security-Project.git
   cd university-management-system
   ```

2. **Install Dependencies**:

   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:

   - Copy `.env.example` to `.env`:

     ```bash
     cp .env.example .env
     ```

   - Update `.env` with your database credentials (MySQL via XAMPP) and other configurations (e.g., mail driver, social login keys).

   - Generate an application key:

     ```bash
     php artisan key:generate
     ```

   - **Setting up OAuth Providers**:
   
     - **Google OAuth**:
       1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
       2. Create a new project
       3. Navigate to "APIs & Services" > "Credentials"
       4. Configure the OAuth consent screen
       5. Create OAuth 2.0 credentials
       6. Add the redirect URI as `http://project.localhost.com/auth/google/callback`
       7. Copy the Client ID and Secret to your `.env` file

     - **GitHub OAuth**:
       1. Go to your [GitHub Developer Settings](https://github.com/settings/developers)
       2. Create a new OAuth App
       3. Set the Authorization callback URL to `http://project.localhost.com/auth/github/callback`
       4. Copy the Client ID and Client Secret to your `.env` file
       
     - **LinkedIn OAuth**:
       1. Go to the [LinkedIn Developer Portal](https://www.linkedin.com/developers/)
       2. Create a new app
       3. Request the necessary permissions
       4. Add the redirect URL: `http://project.localhost.com/auth/linkedin/callback`
       5. Copy the Client ID and Client Secret to your `.env` file

4. **Set Up Database**:

   - Create a MySQL database (e.g., `university_system`) in phpMyAdmin.

   - Run migrations and seed the database:

     ```bash
     php artisan migrate --seed
     ```

5. **Enable SSL Locally**:

   - Use XAMPP's Apache configuration to enable HTTPS.
   - Generate a self-signed SSL certificate using OpenSSL or a tool like `mkcert`.
   - Update `.env` to reflect the HTTPS URL (e.g., `APP_URL=https://localhost`).

6. **Run the Application**:

   ```bash
   php artisan serve
   ```

   - Access the app at `https://localhost:8000` (or your configured port).

7. **Optional Vue.js Setup**:

   - If using Vue.js, compile frontend assets:

     ```bash
     npm run dev
     ```

## Development Workflow

### Git Workflow

- **Branch**: All changes are committed directly to the `main` branch.

- **Force Pushes**: **Strictly prohibited** to avoid overwriting team changes.

- **Daily Updates**: **All team members must push updates to GitHub daily** to ensure consistent progress and collaboration.

- **Steps for Contributing**:

  1. Pull the latest changes from `main`:

     ```bash
     git pull origin main
     ```

  2. Make changes locally.

  3. Commit changes with a descriptive message:

     ```bash
     git commit -m "Add feature X or fix issue Y"
     ```

  4. Push to `main` daily:

     ```bash
     git push origin main
     ```

  5. Resolve any merge conflicts locally before pushing.

### Task Assignment

- **All team members** will contribute to every part of the project, including backend, frontend, authentication, APIs, and security features.
- Use **GitHub Issues** to track tasks, bugs, and feature requests.

### Project Timeline

- **Duration**: 5 weeks (ending approximately mid-May 2025).
- **Milestones**:
  - **Week 1**: Set up Laravel, database, and initial roles/permissions.
  - **Week 2**: Implement authentication (login, register, email verification, password reset).
  - **Week 3**: Develop role editor and social login.
  - **Week 4**: Build and test APIs, publish to Postman, and enable SSL.
  - **Week 5**: Finalize features, test thoroughly, and prepare for submission.

## Security Considerations

- Use **Laravel's built-in security features** (e.g., CSRF protection, input validation).
- Sanitize all user inputs to prevent XSS and SQL injection.
- Secure APIs with **Laravel Sanctum** or **API tokens** for student access.
- Store sensitive data (e.g., API keys, social login credentials) in `.env`.
- Ensure SSL is enabled for all local and production environments.

## API Development

- APIs will be built for student-facing mobile interactions (e.g., view courses, grades).
- Use **Laravel Resource Controllers** for RESTful endpoints.
- Example endpoints:
  - `GET /api/courses`: List available courses.
  - `GET /api/grades`: Retrieve student grades.
- Document all APIs in a **Postman Collection** and publish publicly.

## Testing

- Test authentication flows, role permissions, and API endpoints.
- Manually test the application in a browser with SSL enabled.
- Use Postman to test APIs before publishing.

## Additional Notes

- **Daily updates** to GitHub are mandatory to keep the project on track.
- Regularly communicate via team channels (e.g., WhatsApp, Discord) to coordinate tasks.
- Update this README as new features or processes are added.
- If issues arise (e.g., merge conflicts, setup problems), consult the team immediately.

## Contact

For questions or clarifications, reach out to any team member or create a GitHub Issue.

Happy coding!
