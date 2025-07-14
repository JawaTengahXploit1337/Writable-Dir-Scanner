# Writable Directory Scanner

A simple PHP tool to recursively scan directories starting from a given path and list all writable ("green") folders — useful for auditing uploadable or insecure folders on web servers.

## 📌 Features

- Input any base directory (e.g., `/var/www/html`)
- Recursively scans all subdirectories
- Lists only writable folders (uploadable directories)
- Clean, modern UI with no external dependencies
- Easy to use in local or test environments

## ⚠️ Disclaimer

> **This tool is intended for testing or internal use only.**
>
> Do **not** expose this tool on public servers. It can be misused to gather information about your server's file system.

---

## 🔧 Requirements

- PHP 5.6 or higher (recommended: PHP 7+)
- A web server (Apache, Nginx, etc.) or PHP built-in server

---

## 🚀 How to Use

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/writable-dir-scanner.git
cd writable-dir-scanner
