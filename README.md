# SkillSwap PRO

### _A Peer-to-Peer Learning Marketplace for Students_

**SkillSwap PRO** is a web-based platform designed for students to exchange knowledge. Instead of paying for expensive tutors, students can trade skills they have for skills they want to learn.

> "I teach you Python, you teach me Graphic Design."

## The Vision

In a university environment, everyone is an expert at something. We built this project to bridge the gap between students who want to learn and students who want to mentor. This was developed as a collaborative school project to demonstrate full-stack web development and database logic.

## Key Features

### Smart Matchmaking (The Dashboard)

The system automatically compares your "Learning Goals" with other students' "Expertise." If a direct match exists, it appears instantly on your dashboard.

### Explore & Mutual Swaps

Browse the entire student community. Our unique "Swap Logic" identifies **Mutual Matches** where:

- **Student A** has what **Student B** wants.
- **Student B** has what **Student A** wants.
- The UI explicitly shows: _"John can teach you Java / You can teach John Python."_

### Real-Time Communication

Direct messaging system allowing students to coordinate their learning sessions without leaving the platform.

### Personalized Profiles

Users can manage their skills inventory, updating what they are currently teaching and what they are currently aiming to learn.

## Tech Stack

Our team used the following technologies to build this MVP:

- **Frontend:** HTML5, CSS3, **Tailwind CSS** (for modern, responsive UI).
- **Backend:** **PHP** (Server-side logic and session management).
- **Database:** **MySQL** (Relational data for users, skills, and matches).
- **Icons:** FontAwesome 6.
- **Collaboration:** Git & GitHub.

## Project Structure

```text
/skillswap-pro
│
├── config/           # Database & App configurations
├── includes/         # Header, Footer, and reusable UI components
├── assets/           # Images, CSS, and JS files
├── dashboard.php     # Personalized user home
├── explore.php       # Community directory & filtering
├── manage_skills.php # Skill inventory management
├── chat.php          # Real-time messaging interface
└── index.php         # Landing page
```

## Installation & Local Setup

To run this project locally, follow these steps:

1. **Clone the repo:**
   ```bash
   git clone https://github.com/ahlami24/skillswapPRO.git
   ```
2. **Setup Database:**
   - Open **phpMyAdmin**.
   - Create a database named `skillswap_db`.
   - Import the `database.sql` file provided in the repository.
3. **Configure Connection:**
   - Navigate to `config/db.php`.
   - Update the database credentials (host, username, password).
4. **Run:**
   - Place the folder in your `htdocs` (XAMPP) or `www` (WAMP) directory.
   - Open `http://localhost/skillswap-pro` in your browser.

## The Team

This project was a collaborative effort by:

- **Abdulaziz Abdurahman**
- **Muslim Raya**
- **Nigus Hagos**
- **Kiya gizaw**
- **Helen Kokob**
