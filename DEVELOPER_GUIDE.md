# Complete Developer Guide
## Content Management System with Multilingual Support

---

## Table of Contents
1. [Overview](#overview)
2. [System Architecture](#system-architecture)
3. [API Documentation](#api-documentation)
4. [Database Structure](#database-structure)
5. [Admin Panel Guide](#admin-panel-guide)
6. [Mobile App Integration](#mobile-app-integration)
7. [Implementation Examples](#implementation-examples)
8. [Setup & Installation](#setup--installation)

---

## Overview

### What is This System?

A complete Content Management System built with Laravel 12, featuring:
- ✅ **Multilingual Support** - English, Urdu (اردو), Arabic (العربية), Pashto (پښتو)
- ✅ **Icon Library** - Upload and manage custom icons (PNG, SVG, JPG, WEBP)
- ✅ **Three Content Types** - Text, Q&A, PDF (via external URL)
- ✅ **RESTful API** - Ready for mobile app integration
- ✅ **Beautiful Admin UI** - Clean, responsive, mobile-friendly
- ✅ **RTL Support** - Full support for right-to-left languages

### System Flow

```
Categories (Main Cards)
    └── Subcategories
        └── Contents (Text / Q&A / PDF)
```

**User Journey:**
1. Home Screen → Shows categories
2. Tap Category → Shows subcategories
3. Tap Subcategory → Shows content list
4. Tap Content → Shows full content

---

## System Architecture

### Technology Stack
- **Backend:** Laravel 12 (PHP 8.2+)
- **Database:** SQLite
- **Frontend:** Blade Templates + Tailwind CSS 4
- **Build Tool:** Vite
- **Assets:** Stored in `storage/app/public/`

### Directory Structure
```
app/
├── Models/
│   ├── Category.php
│   ├── Subcategory.php
│   ├── Content.php
│   └── IconLibrary.php
├── Http/Controllers/
│   ├── Api/
│   │   └── ContentApiController.php
│   ├── ContentManagementController.php
│   └── IconLibraryController.php

database/
├── migrations/
│   ├── *_create_categories_table.php
│   ├── *_create_subcategories_table.php
│   ├── *_create_contents_table.php
│   ├── *_create_icon_library_table.php
│   └── *_update_*.php

resources/
└── views/
    ├── content-management/
    │   ├── categories/
    │   ├── subcategories/
    │   └── contents/
    └── icon-library/

routes/
├── api.php      # API endpoints
└── web.php      # Admin panel routes
```

---

## API Documentation

### Base URL
```
https://yourdomain.com/api
```

### Authentication

**🔐 API Key Required** - All endpoints require authentication.

#### How to Authenticate

Every API request must include the API key in the request header:

**Header Name:** `X-API-Key`  
**Header Value:** Your API key from `.env` file

#### Example Request with Authentication

```bash
# cURL Example
curl -H "X-API-Key: your-api-key-here" \
     https://yourdomain.com/api/categories
```

```javascript
// JavaScript/Fetch Example
fetch('https://yourdomain.com/api/categories', {
  headers: {
    'X-API-Key': 'your-api-key-here'
  }
})
```

```dart
// Flutter/Dart Example
final response = await http.get(
  Uri.parse('https://yourdomain.com/api/categories'),
  headers: {
    'X-API-Key': 'your-api-key-here'
  }
);
```

```swift
// Swift/iOS Example
var request = URLRequest(url: url)
request.addValue("your-api-key-here", forHTTPHeaderField: "X-API-Key")
```

#### Error Response (401 Unauthorized)

If API key is missing or invalid:

```json
{
  "success": false,
  "message": "Unauthorized. Invalid or missing API key."
}
```

**Status Code:** 401

---

### 1. Get All Categories

**Endpoint:** `GET /api/categories`

**Response:**
```json
{
  "success": true,
  "message": "Categories retrieved successfully",
  "data": [
    {
      "id": 1,
      "names": {
        "english": "Islamic Studies",
        "urdu": "اسلامی تعلیمات",
        "arabic": "الدراسات الإسلامية",
        "pashto": "اسلامي زده کړې"
      },
      "description": "Learn about Islamic teachings",
      "icon_url": "https://yourdomain.com/storage/icons/islamic.png",
      "color": "#10b981",
      "subcategories_count": 5
    }
  ]
}
```

**Use Case:** Display main category cards on app homepage

---

### 2. Get Single Category

**Endpoint:** `GET /api/categories/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Category retrieved successfully",
  "data": {
    "id": 1,
    "names": {
      "english": "Islamic Studies",
      "urdu": "اسلامی تعلیمات",
      "arabic": "الدراسات الإسلامية",
      "pashto": "اسلامي زده کړې"
    },
    "description": "Learn about Islamic teachings",
    "icon_url": "https://yourdomain.com/storage/icons/islamic.png",
    "color": "#10b981",
    "subcategories": [
      {
        "id": 1,
        "name": "Quran",
        "description": "About Holy Quran",
        "contents_count": 10
      }
    ]
  }
}
```

**Use Case:** Display subcategories when user taps a category

---

### 3. Get Subcategory with Contents

**Endpoint:** `GET /api/subcategories/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Subcategory retrieved successfully",
  "data": {
    "id": 1,
    "name": "Quran",
    "description": "About Holy Quran",
    "category": {
      "id": 1,
      "names": {
        "english": "Islamic Studies",
        "urdu": "اسلامی تعلیمات",
        "arabic": "الدراسات الإسلامية",
        "pashto": "اسلامي زده کړې"
      },
      "icon_url": "https://yourdomain.com/storage/icons/islamic.png",
      "color": "#10b981"
    },
    "contents": [
      {
        "id": 1,
        "type": "text",
        "title": "Introduction to Quran",
        "text_content": "The Quran is..."
      },
      {
        "id": 2,
        "type": "qa",
        "title": "What is Quran?",
        "question": "What is the Quran?",
        "answer": "The Quran is..."
      },
      {
        "id": 3,
        "type": "pdf",
        "title": "Quran Study Guide",
        "pdf_url": "https://f000.backblazeb2.com/file/bucket/guide.pdf"
      }
    ]
  }
}
```

**Use Case:** Display all content in a subcategory

---

### 4. Get Single Content

**Endpoint:** `GET /api/contents/{id}`

**Response (Text):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "type": "text",
    "title": "Introduction to Quran",
    "text_content": "Full text content here...",
    "subcategory": {
      "id": 1,
      "name": "Quran"
    },
    "category": {
      "id": 1,
      "names": {...},
      "icon_url": "...",
      "color": "#10b981"
    }
  }
}
```

**Response (Q&A):**
```json
{
  "type": "qa",
  "title": "What is Quran?",
  "question": "What is the Quran?",
  "answer": "The Quran is the holy book..."
}
```

**Response (PDF):**
```json
{
  "type": "pdf",
  "title": "Study Guide",
  "pdf_url": "https://f000.backblazeb2.com/file/bucket/guide.pdf"
}
```

**Use Case:** Display full content details

---

### 5. Search Content

**Endpoint:** `GET /api/search?q={query}`

**Response:**
```json
{
  "success": true,
  "message": "Search completed successfully",
  "query": "quran",
  "results_count": 3,
  "data": [
    {
      "id": 1,
      "type": "text",
      "title": "Introduction to Quran",
      "preview": "The Quran is...",
      "subcategory": {
        "id": 1,
        "name": "Quran"
      },
      "category": {
        "id": 1,
        "names": {...}
      }
    }
  ]
}
```

**Use Case:** Search functionality in app

---

### Content Types

#### 1. Text Content (`type: "text"`)
- Plain or formatted text
- Field: `text_content`
- Best for: Articles, lessons, explanations

#### 2. Q&A Content (`type: "qa"`)
- Question and answer pairs
- Fields: `question`, `answer`
- Best for: FAQs, knowledge base

#### 3. PDF Content (`type: "pdf"`)
- External PDF URL (Backblaze B2, CDN)
- Field: `pdf_url`
- Best for: Books, guides, downloadable content
- **Note:** PDFs are NOT uploaded to server - use external URL

---

## Database Structure

### Categories Table
```sql
CREATE TABLE categories (
  id INTEGER PRIMARY KEY,
  name_english VARCHAR(255) NOT NULL,
  name_urdu VARCHAR(255) NOT NULL,
  name_arabic VARCHAR(255) NOT NULL,
  name_pashto VARCHAR(255) NOT NULL,
  description TEXT,
  icon_library_id INTEGER REFERENCES icon_library(id),
  color VARCHAR(7) DEFAULT '#10b981',
  order INTEGER DEFAULT 0,
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Icon Library Table
```sql
CREATE TABLE icon_library (
  id INTEGER PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  file_type VARCHAR(10) NOT NULL,
  file_size INTEGER NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Subcategories Table
```sql
CREATE TABLE subcategories (
  id INTEGER PRIMARY KEY,
  category_id INTEGER REFERENCES categories(id) ON DELETE CASCADE,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  order INTEGER DEFAULT 0,
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Contents Table
```sql
CREATE TABLE contents (
  id INTEGER PRIMARY KEY,
  subcategory_id INTEGER REFERENCES subcategories(id) ON DELETE CASCADE,
  type ENUM('text', 'qa', 'pdf') NOT NULL,
  title VARCHAR(255) NOT NULL,
  text_content LONGTEXT,          -- For text type
  question TEXT,                   -- For qa type
  answer LONGTEXT,                 -- For qa type
  pdf_url VARCHAR(500),            -- For pdf type (external URL)
  order INTEGER DEFAULT 0,
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Relationships
```
categories (1) ──→ (many) subcategories (1) ──→ (many) contents
categories (1) ──→ (1) icon_library
```

**Cascading Deletes:**
- Delete category → Deletes all subcategories → Deletes all contents
- Icons in use cannot be deleted

---

## Admin Panel Guide

### Access
```
https://yourdomain.com/content-management
```

### Features

#### 1. Icon Library
**Path:** `/icon-library`

**Upload Icons:**
- Formats: PNG, SVG, JPG, WEBP
- Max size: 2MB
- Recommended: Square images (512x512px)

**Usage:**
1. Upload icons first
2. Select from library when creating categories
3. Icons are reusable across categories

#### 2. Categories
**Path:** `/content-management/categories`

**Create Category:**
```
1. Click "Add Category"
2. Fill in all 4 language names:
   - English (required)
   - Urdu (required) - RTL input
   - Arabic (required) - RTL input
   - Pashto (required) - RTL input
3. Add description (optional)
4. Select icon from library
5. Choose color
6. Set display order (lower = first)
7. Check "Active" to make visible
8. Save
```

#### 3. Subcategories
**Path:** `/content-management/subcategories`

**Create Subcategory:**
```
1. Click "Add Subcategory"
2. Select parent category
3. Enter name
4. Add description (optional)
5. Set order
6. Mark as active
7. Save
```

#### 4. Contents
**Path:** `/content-management/contents`

**Create Content:**
```
1. Click "Add Content"
2. Select category (filters subcategories)
3. Select subcategory
4. Choose content type (Text/Q&A/PDF)
5. Enter title

For Text:
  - Enter full text content

For Q&A:
  - Enter question
  - Enter answer

For PDF:
  - Enter Backblaze B2 URL or CDN URL
  - Example: https://f000.backblazeb2.com/file/bucket/file.pdf

6. Set order
7. Mark as active
8. Save
```

---

## Mobile App Integration

### Language Support

**Detecting User Language:**
```javascript
// Get device language
const deviceLanguage = navigator.language; // 'en', 'ur', 'ar', 'ps'

// Map to API language keys
const languageMap = {
  'en': 'english',
  'ur': 'urdu',
  'ar': 'arabic',
  'ps': 'pashto'
};

const userLanguage = languageMap[deviceLanguage] || 'english';
```

**Using Multilingual Names:**
```javascript
// Fetch categories
const response = await fetch('https://yourdomain.com/api/categories');
const { data } = await response.json();

// Display in user's language
data.forEach(category => {
  const displayName = category.names[userLanguage];
  console.log(displayName); // Shows "اسلامی تعلیمات" for Urdu
});
```

### Recommended Flow

#### 1. Home Screen
```javascript
// Fetch categories
const categories = await fetch('/api/categories').then(r => r.json());

// Display category cards
categories.data.forEach(category => {
  // Show icon
  <img src={category.icon_url} />
  
  // Show name in user's language
  <h3>{category.names[userLanguage]}</h3>
  
  // Show count
  <p>{category.subcategories_count} topics</p>
  
  // Apply category color
  <div style={{borderColor: category.color}} />
});
```

#### 2. Category Screen
```javascript
// Fetch category with subcategories
const category = await fetch(`/api/categories/${id}`).then(r => r.json());

// Display subcategories list
category.data.subcategories.forEach(sub => {
  <div>
    <h4>{sub.name}</h4>
    <p>{sub.contents_count} items</p>
  </div>
});
```

#### 3. Subcategory Screen
```javascript
// Fetch subcategory with contents
const subcategory = await fetch(`/api/subcategories/${id}`).then(r => r.json());

// Display content items with type-specific icons
subcategory.data.contents.forEach(content => {
  const icon = {
    'text': '📄',
    'qa': '❓',
    'pdf': '📕'
  }[content.type];
  
  <div>
    <span>{icon}</span>
    <h5>{content.title}</h5>
  </div>
});
```

#### 4. Content Detail Screen
```javascript
// Fetch content
const content = await fetch(`/api/contents/${id}`).then(r => r.json());

// Display based on type
switch(content.data.type) {
  case 'text':
    return <div>{content.data.text_content}</div>;
    
  case 'qa':
    return (
      <div>
        <h4>Q: {content.data.question}</h4>
        <p>A: {content.data.answer}</p>
      </div>
    );
    
  case 'pdf':
    return (
      <a href={content.data.pdf_url} target="_blank">
        Open PDF
      </a>
    );
}
```

---

## Implementation Examples

### Important: API Authentication Setup

**All code examples below assume you've stored the API key securely in your app.**

#### How to Store API Key in Mobile Apps

**JavaScript/React Native:**
```javascript
// .env file
API_KEY=your-api-key-here

// Access in code
const API_KEY = process.env.API_KEY;
```

**Flutter:**
```dart
// .env file
API_KEY=your-api-key-here

// Use flutter_dotenv package
final apiKey = dotenv.env['API_KEY'];
```

**iOS/Swift:**
```swift
// Config.plist
<key>API_KEY</key>
<string>your-api-key-here</string>

// Access in code
let apiKey = Bundle.main.object(forInfoDictionaryKey: "API_KEY") as? String
```

---

### JavaScript/React Native

```javascript
import React, { useState, useEffect } from 'react';

// API Configuration
const API_BASE_URL = 'https://yourdomain.com/api';
const API_KEY = process.env.API_KEY; // Store securely

// API Helper Function with Authentication
const apiRequest = async (endpoint) => {
  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    headers: {
      'X-API-Key': API_KEY
    }
  });
  
  if (!response.ok) {
    if (response.status === 401) {
      throw new Error('Unauthorized: Invalid API key');
    }
    throw new Error('API request failed');
  }
  
  return await response.json();
};

// 1. Language Selector Component
const LanguageSelector = ({ onLanguageChange }) => {
  return (
    <select onChange={(e) => onLanguageChange(e.target.value)}>
      <option value="english">English</option>
      <option value="urdu">اردو</option>
      <option value="arabic">العربية</option>
      <option value="pashto">پښتو</option>
    </select>
  );
};

// 2. Category Card Component
const CategoryCard = ({ category, language }) => {
  const name = category.names[language];
  
  return (
    <div style={{ borderColor: category.color }}>
      <img src={category.icon_url} alt={name} />
      <h3>{name}</h3>
      <p>{category.subcategories_count} topics</p>
    </div>
  );
};

// 3. Content Viewer Component
const ContentViewer = ({ content }) => {
  switch(content.type) {
    case 'text':
      return <div dangerouslySetInnerHTML={{ __html: content.text_content }} />;
      
    case 'qa':
      return (
        <div>
          <h4>Q: {content.question}</h4>
          <p>A: {content.answer}</p>
        </div>
      );
      
    case 'pdf':
      return (
        <a href={content.pdf_url} target="_blank" rel="noopener noreferrer">
          View PDF Document
        </a>
      );
  }
};

// 4. Complete App Example with API Authentication
const App = () => {
  const [language, setLanguage] = useState('english');
  const [categories, setCategories] = useState([]);
  const [error, setError] = useState(null);
  
  useEffect(() => {
    apiRequest('/categories')
      .then(data => setCategories(data.data))
      .catch(err => setError(err.message));
  }, []);
  
  return (
    <div>
      <LanguageSelector onLanguageChange={setLanguage} />
      <div className="categories-grid">
        {categories.map(category => (
          <CategoryCard 
            key={category.id}
            category={category}
            language={language}
          />
        ))}
      </div>
    </div>
  );
};
```

### Flutter/Dart

```dart
// 1. Models
class Category {
  final int id;
  final Map<String, String> names;
  final String iconUrl;
  final String color;
  final int subcategoriesCount;
  
  String getName(String language) => names[language] ?? names['english']!;
}

class Content {
  final int id;
  final String type;
  final String title;
  final String? textContent;
  final String? question;
  final String? answer;
  final String? pdfUrl;
}

// 2. API Service with Authentication
class ApiService {
  static const String baseUrl = 'https://yourdomain.com/api';
  static const String apiKey = String.fromEnvironment('API_KEY'); // Store securely
  
  // Helper method to get headers with API key
  Map<String, String> get _headers => {
    'X-API-Key': apiKey,
    'Content-Type': 'application/json',
  };
  
  Future<List<Category>> getCategories() async {
    final response = await http.get(
      Uri.parse('$baseUrl/categories'),
      headers: _headers,
    );
    
    if (response.statusCode == 401) {
      throw Exception('Unauthorized: Invalid API key');
    }
    
    final data = json.decode(response.body);
    return (data['data'] as List)
        .map((json) => Category.fromJson(json))
        .toList();
  }
  
  Future<Subcategory> getSubcategory(int id) async {
    final response = await http.get(
      Uri.parse('$baseUrl/subcategories/$id'),
      headers: _headers,
    );
    
    if (response.statusCode == 401) {
      throw Exception('Unauthorized: Invalid API key');
    }
    
    final data = json.decode(response.body);
    return Subcategory.fromJson(data['data']);
  }
}

// 3. Category Card Widget
class CategoryCard extends StatelessWidget {
  final Category category;
  final String language;
  
  @override
  Widget build(BuildContext context) {
    return Card(
      child: Column(
        children: [
          Image.network(category.iconUrl),
          Text(category.getName(language)),
          Text('${category.subcategoriesCount} topics'),
        ],
      ),
    );
  }
}

// 4. Content Viewer Widget
class ContentViewer extends StatelessWidget {
  final Content content;
  
  @override
  Widget build(BuildContext context) {
    switch (content.type) {
      case 'text':
        return Text(content.textContent ?? '');
      case 'qa':
        return Column(
          children: [
            Text('Q: ${content.question}'),
            Text('A: ${content.answer}'),
          ],
        );
      case 'pdf':
        return ElevatedButton(
          onPressed: () => launch(content.pdfUrl!),
          child: Text('Open PDF'),
        );
      default:
        return SizedBox();
    }
  }
}
```

### Swift/iOS

```swift
// 1. Models
struct Category: Codable {
    let id: Int
    let names: [String: String]
    let iconUrl: String
    let color: String
    let subcategoriesCount: Int
    
    func getName(language: String) -> String {
        return names[language] ?? names["english"] ?? ""
    }
}

struct Content: Codable {
    let id: Int
    let type: String
    let title: String
    let textContent: String?
    let question: String?
    let answer: String?
    let pdfUrl: String?
}

// 2. API Service with Authentication
class APIService {
    static let baseURL = "https://yourdomain.com/api"
    static let apiKey = Bundle.main.object(forInfoDictionaryKey: "API_KEY") as? String ?? ""
    
    // Helper method to create authenticated request
    func createRequest(url: URL) -> URLRequest {
        var request = URLRequest(url: url)
        request.addValue(APIService.apiKey, forHTTPHeaderField: "X-API-Key")
        return request
    }
    
    func getCategories(completion: @escaping (Result<[Category], Error>) -> Void) {
        guard let url = URL(string: "\(APIService.baseURL)/categories") else { return }
        
        let request = createRequest(url: url)
        
        URLSession.shared.dataTask(with: request) { data, response, error in
            if let error = error {
                completion(.failure(error))
                return
            }
            
            guard let httpResponse = response as? HTTPURLResponse else { return }
            
            if httpResponse.statusCode == 401 {
                completion(.failure(NSError(domain: "", code: 401, 
                    userInfo: [NSLocalizedDescriptionKey: "Unauthorized: Invalid API key"])))
                return
            }
            
            guard let data = data else { return }
            
            do {
                let response = try JSONDecoder().decode(APIResponse<[Category]>.self, from: data)
                completion(.success(response.data))
            } catch {
                completion(.failure(error))
            }
        }.resume()
    }
}

// 3. Category Cell
class CategoryCell: UITableViewCell {
    func configure(with category: Category, language: String) {
        textLabel?.text = category.getName(language: language)
        
        // Load icon
        if let url = URL(string: category.iconUrl) {
            URLSession.shared.dataTask(with: url) { data, _, _ in
                guard let data = data else { return }
                DispatchQueue.main.async {
                    self.imageView?.image = UIImage(data: data)
                }
            }.resume()
        }
    }
}
```

---

## Setup & Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite

### Installation Steps

```bash
# 1. Clone repository
git clone <repository-url>
cd quran_xml_maker

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Run migrations
php artisan migrate

# 7. Create storage symlink
php artisan storage:link

# 8. Build assets
npm run build

# 9. Start development server
php artisan serve
```

### Access Points

- **Admin Panel:** http://localhost:8000/content-management
- **API Base:** http://localhost:8000/api
- **Icon Library:** http://localhost:8000/icon-library

### Default Login
Create admin account:
```bash
php artisan tinker
> $user = new App\Models\User();
> $user->name = 'Admin';
> $user->email = 'admin@example.com';
> $user->password = bcrypt('password');
> $user->is_admin = true;
> $user->save();
```

---

## Best Practices

### For Admins

1. **Upload Icons First**
   - Create icon library before adding categories
   - Use square images (512x512px recommended)
   - Use SVG for best scalability

2. **Multilingual Content**
   - Fill all 4 language fields
   - Keep names consistent in meaning across languages
   - Use native speakers for translations

3. **PDF Hosting**
   - Use Backblaze B2 or reliable CDN
   - Test URLs before saving
   - Use descriptive filenames

4. **Content Organization**
   - Use logical category structure
   - Keep subcategories focused
   - Use display order effectively

### For Developers

1. **API Security**
   - **Never hardcode API key** in source code
   - Store API key in environment variables or secure storage
   - Use HTTPS only in production
   - Handle 401 errors (unauthorized) gracefully
   - Don't log API keys in debug output
   - Implement request timeout (30 seconds recommended)

2. **Language Handling**
   - Store user's language preference
   - Default to device language
   - Always have fallback to English

3. **Caching**
   - Cache category data (changes infrequently)
   - Implement pull-to-refresh
   - Cache icons locally

4. **Error Handling**
   - Handle network errors gracefully
   - Show offline mode when needed
   - Validate API responses
   - Check for 401 (unauthorized) and refresh auth if needed

5. **Performance**
   - Lazy load images
   - Paginate large lists
   - Implement search debouncing

6. **RTL Support**
   - Detect RTL languages (Urdu, Arabic, Pashto)
   - Flip UI layout for RTL
   - Test thoroughly with RTL content

---

## API Quick Reference

### Authentication (Required for All Endpoints)
```
Header: X-API-Key
Value:  Your API key from .env file
```

### Endpoints

**Content Management APIs:**
```
GET  /api/categories              → All categories
GET  /api/categories/{id}         → Single category + subcategories
GET  /api/subcategories/{id}      → Subcategory + contents
GET  /api/contents/{id}           → Single content item
GET  /api/search?q={query}        → Search results
```

**Quran APIs (د آیات فایدی، د آیات تفسیر، د آیه لغات):**
```
GET  /api/ayah/{surah}/{ayah}           → All sections for an ayah
GET  /api/ayah/{surah}/{ayah}/{type}    → Specific section (lughat/tafseer/faidi)
GET  /api/section/{type}                → All data for section type
GET  /api/surah/{surah}/{type}          → Surah section data
GET  /api/surahs                         → All surahs info
GET  /api/surah/{surah}                  → Single surah info
```

**Language Access:**
```javascript
category.names.english
category.names.urdu
category.names.arabic
category.names.pashto
```

**Content Types:**
```
'text' → text_content
'qa'   → question + answer
'pdf'  → pdf_url (external)
```

---

## Support & Maintenance

### Backup Strategy
```bash
# Backup database
cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite

# Backup icons
tar -czf icons-backup.tar.gz storage/app/public/icons/
```

### Troubleshooting

**Issue: Icons not showing**
```bash
php artisan storage:link
```

**Issue: API returns empty**
- Check if content is marked as "active"
- Verify database has data
- Check API routes: `php artisan route:list`

**Issue: RTL not working**
- Ensure `dir="rtl"` attribute on parent elements
- Test with actual RTL content
- Check CSS for RTL support

---

## Summary

You now have a complete Content Management System with:
- ✅ Multilingual support (4 languages)
- ✅ Icon library system
- ✅ Three content types (Text, Q&A, PDF)
- ✅ RESTful API for mobile apps
- ✅ Beautiful admin panel
- ✅ Complete documentation

**Next Steps:**
1. Upload icons to library
2. Create categories with all language names
3. Add subcategories
4. Create content
5. Integrate API in mobile app
6. Add language switcher in app
7. Test with real users

**Everything is ready for production! 🚀**

---

**Version:** 1.0  
**Last Updated:** December 2025  
**Framework:** Laravel 12  
**Database:** SQLite  
**License:** MIT

