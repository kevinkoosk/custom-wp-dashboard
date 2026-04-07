# Custom Dashboard Gatekeeper Pro
You're welcome! Moving this to GitHub is a great way to keep your code versioned and shareable. Below is the complete setup: the README.md file and the final version of the plugin code, followed by a quick guide on how to handle GitHub "Releases."

1. The README.md File
Markdown
# Custom Dashboard Gatekeeper Pro

A lightweight, developer-friendly WordPress plugin that replaces the cluttered `/wp-admin` dashboard with a custom-designed page for non-administrator users. 

**No bloat. No complex "Membership" logic. Just clean redirects.**

---

## 🚀 Why Use This?
Standard WordPress behavior treats every user like a site editor. For client portals or member areas, showing the WordPress back-end is confusing and unprofessional. 

**Custom Dashboard Gatekeeper Pro** allows you to design a dashboard using your favorite page builder (or Gutenberg) and ensures your users never see the WordPress admin interface.

## ✨ Key Features
* **Automatic Redirects:** Non-admin users are sent to your custom page immediately after logging in.
* **Back-end Lockdown:** Direct access to `/wp-admin` is blocked and redirected for non-admins.
* **Stealth Mode:** Hides the WordPress Admin Bar for all non-administrators.
* **Public Protection:** Redirects logged-out visitors away from your dashboard back to the homepage.
* **Smart Validation:** Prevents broken links by verifying your chosen slug exists before saving.

---

## 🛠 Installation

1. **Download** the latest release `.zip` file from the [Releases](#) section.
2. In your WordPress admin, go to **Plugins > Add New > Upload Plugin**.
3. Choose the `.zip` file and click **Install Now**.
4. **Activate** the plugin.

---

## ⚙️ How to Configure

1. **Create your Page:** Go to `Pages > Add New` and create your dashboard. Note the **URL Slug** (e.g., `my-portal`).
2. **Set the Gatekeeper:** Go to `Settings > Dashboard Gatekeeper`.
3. **Enter the Slug:** Type your slug into the field and hit **Save Changes**.
4. **Validation:** If the page exists, you're set! If not, the plugin will warn you to create the page first.

---

## 📂 Technical Details
* **Requirements:** WordPress 5.0+
* **Lightweight:** Under 5kb. Uses standard `wp_options` table.
* **Developer Friendly:** Built with clean hooks (`template_redirect`, `login_redirect`, and `admin_init`).

---

## 📄 License
This project is licensed under the GPLv2 or later.
