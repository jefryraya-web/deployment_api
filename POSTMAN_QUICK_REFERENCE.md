# 📮 POSTMAN QUICK REFERENCE - Item Manager API

## Base URL
```
http://deployment.test/api
```

---

## 📌 API Endpoints Quick Copy-Paste

### 1️⃣ GET - List All Items
```
GET /api/items
```
**No headers or body needed**

---

### 2️⃣ GET - Get Item Detail
```
GET /api/items/1
```
Replace `1` with actual item ID

---

### 3️⃣ POST - Create New Item
```
POST /api/items
Content-Type: application/json

{
  "title": "Item Title Here",
  "content": "Item description here"
}
```

**Sample Request:**
```json
{
  "title": "Belajar JavaScript",
  "content": "JavaScript adalah bahasa pemrograman untuk web"
}
```

---

### 4️⃣ PUT - Update Item
```
PUT /api/items/1
Content-Type: application/json

{
  "title": "Updated Title",
  "content": "Updated content"
}
```

Replace `1` with actual item ID

**Sample Request:**
```json
{
  "title": "Master JavaScript",
  "content": "JavaScript advanced concepts dan best practices"
}
```

---

### 5️⃣ DELETE - Delete Item
```
DELETE /api/items/1
```

Replace `1` with item ID to delete
**No body needed**

---

## 🧪 Test Scenario (Copy-Paste Order)

Execute these requests in order:

### Step 1: Get Current Items
```
GET http://deployment.test/api/items
```

### Step 2: Add Item 1
```
POST http://deployment.test/api/items
Content-Type: application/json

{
  "title": "Test Item 1",
  "content": "This is test item number 1"
}
```

### Step 3: Add Item 2
```
POST http://deployment.test/api/items
Content-Type: application/json

{
  "title": "Test Item 2",
  "content": "This is test item number 2"
}
```

### Step 4: Verify Items Added
```
GET http://deployment.test/api/items
```
*Note the IDs of newly created items*

### Step 5: Update Item (Replace ID)
```
PUT http://deployment.test/api/items/1
Content-Type: application/json

{
  "title": "Updated Test Item 1",
  "content": "This item has been updated"
}
```

### Step 6: Get Item Detail
```
GET http://deployment.test/api/items/1
```

### Step 7: Delete Item (Replace ID)
```
DELETE http://deployment.test/api/items/1
```

### Step 8: Verify Deletion
```
GET http://deployment.test/api/items
```
*Item should be removed from list*

---

## 📝 Response Examples

### GET List Response (200 OK)
```json
[
  {
    "id": 1,
    "title": "Belajar PHP",
    "content": "PHP adalah bahasa server-side",
    "created_at": "2025-12-10 10:30:00",
    "updated_at": "2025-12-10 10:30:00"
  },
  {
    "id": 2,
    "title": "Belajar JavaScript",
    "content": "JavaScript adalah bahasa client-side",
    "created_at": "2025-12-10 11:00:00",
    "updated_at": "2025-12-10 11:00:00"
  }
]
```

### POST Create Response (201 Created)
```json
{
  "id": 3,
  "title": "New Item",
  "content": "This is a new item",
  "created_at": "2025-12-10 12:00:00",
  "updated_at": "2025-12-10 12:00:00"
}
```

### PUT Update Response (200 OK)
```json
{
  "id": 1,
  "title": "Updated Title",
  "content": "Updated content",
  "updated_at": "2025-12-10 12:30:00"
}
```

### DELETE Response (200 OK)
```json
{
  "message": "Item deleted"
}
```

### Error Response (400 Bad Request)
```json
{
  "error": "Title is required"
}
```

### Error Response (404 Not Found)
```json
{
  "error": "Not found"
}
```

---

## 🔑 HTTP Status Codes

| Code | Meaning | Use Case |
|------|---------|----------|
| 200 | OK | GET, PUT, DELETE successful |
| 201 | Created | POST successful |
| 400 | Bad Request | Missing required field (title) |
| 404 | Not Found | Item ID doesn't exist |
| 500 | Server Error | Server error (contact admin) |

---

## 💡 Tips

1. **Always set headers for POST/PUT:**
   - Key: `Content-Type`
   - Value: `application/json`

2. **Save your requests** in Postman for reuse:
   - Right-click request → Save as

3. **Use variables** for dynamic IDs:
   - Replace hardcoded IDs with `{{itemId}}`
   - Set variable in Tests tab: `pm.environment.set("itemId", pm.response.json().id)`

4. **Test error cases:**
   - POST without title
   - GET/PUT/DELETE with non-existent ID
   - POST with invalid JSON

5. **Monitor your data:**
   - Call GET before and after modification
   - Verify timestamps update correctly

---

## 🚀 Troubleshooting

### "Cannot GET /api/items"
- Check if server is running (Laragon or `php -S localhost:8000`)
- Verify URL is correct: `http://deployment.test/api/items`
- Check internet/network connection

### "Invalid JSON" Error
- Verify headers include: `Content-Type: application/json`
- Check JSON syntax (matching quotes, commas, brackets)
- Use Postman's JSON validator

### "Title is required" Error
- Make sure request body includes `"title"` field
- Title must be non-empty string

### Item not showing in list
- Refresh page in browser
- Check GET request returns data
- Verify data.json file exists at `api/data.json`

---

## 📚 Additional Resources

- Full Documentation: `README.md`
- Postman Collection: `Item_Manager_API.postman_collection.json`
- API Code: `api/index.php`
- Frontend Code: `public/app.js`

---

Generated: December 2025
