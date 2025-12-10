const API_BASE = "https://deploymentapi-production.up.railway.app/api/items";
let allItems = [];

// Fungsi dasar untuk API call
async function fetchAPI(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: { "Content-Type": "application/json", ...options.headers },
            ...options
        });
        
        const text = await response.text();
        console.log("Raw response:", text);
        
        let data;
        try {
            data = text ? JSON.parse(text) : null;
        } catch (e) {
            console.error("JSON Parse Error:", e, "Text:", text);
            throw new Error("Server returned invalid JSON: " + text.substring(0, 100));
        }
        
        if (!response.ok) {
            const errMsg = data?.error || `HTTP ${response.status}`;
            throw new Error(errMsg);
        }
        return data || [];
    } catch (error) {
        console.error("API Error:", error);
        showAlert(" " + error.message, "error");
        throw error;
    }
}

function showAlert(msg, type = "success") {
    const alertClass = type === "error" ? "alert-error" : "alert-success";
    const alertEl = document.createElement("div");
    alertEl.className = `alert ${alertClass}`;
    alertEl.textContent = msg;
    document.body.appendChild(alertEl);
    setTimeout(() => alertEl.remove(), 3000);
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

// Load items
async function loadItems() {
    try {
        const container = document.getElementById("items-container");
        container.innerHTML = '<div class="loading">⏳ Memuat...</div>';
        
        console.log("Loading items from:", API_BASE);
        allItems = await fetchAPI(API_BASE);
        console.log("Items loaded:", allItems);
        
        renderItems(allItems);
    } catch (error) {
        console.error("Load failed:", error);
        document.getElementById("items-container").innerHTML = '<div class="error"> Gagal memuat data</div>';
    }
}

function renderItems(items) {
    const container = document.getElementById("items-container");
    
    if (!items || items.length === 0) {
        container.innerHTML = '<div class="empty-state"><p> Tidak ada item</p></div>';
        return;
    }

    container.innerHTML = items.map(item => `
        <div class="item-card">
            <div class="item-header">
                <h3 class="item-title">${escapeHtml(item.title)}</h3>
                <span class="item-id">ID: ${item.id}</span>
            </div>
            <p class="item-content">${escapeHtml(item.content || "")}</p>
            <div class="item-meta">
                <small>${item.created_at ? new Date(item.created_at).toLocaleDateString("id-ID") : "N/A"}</small>
            </div>
            <div class="item-actions">
                <button class="btn-edit" data-id="${item.id}"> Ubah</button>
                <button class="btn-delete" data-id="${item.id}"> Hapus</button>
            </div>
        </div>
    `).join("");

    // Attach events
    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.onclick = () => editItem(parseInt(btn.dataset.id));
    });

    document.querySelectorAll(".btn-delete").forEach(btn => {
        btn.onclick = () => deleteItem(parseInt(btn.dataset.id));
    });
}

// Edit item
async function editItem(id) {
    const item = allItems.find(i => i.id === id);
    if (item) {
        document.getElementById("item-id").value = item.id;
        document.getElementById("title").value = item.title;
        document.getElementById("content").value = item.content || "";
        document.getElementById("form-title").textContent = " Ubah Item";
        document.querySelector(".form-card").scrollIntoView({ behavior: "smooth" });
    }
}

// Delete item
async function deleteItem(id) {
    if (confirm("Yakin ingin menghapus item ini?")) {
        try {
            await fetchAPI(`${API_BASE}/${id}`, { method: "DELETE" });
            showAlert(" Item dihapus", "success");
            loadItems();
        } catch (error) {
            // Error sudah ditangani
        }
    }
}

// Reset form
function resetForm() {
    document.getElementById("item-id").value = "";
    document.getElementById("title").value = "";
    document.getElementById("content").value = "";
    document.getElementById("form-title").textContent = " Tambah Item Baru";
}

// Form submit
document.getElementById("item-form").addEventListener("submit", async (e) => {
    e.preventDefault();
    
    const id = document.getElementById("item-id").value;
    const title = document.getElementById("title").value.trim();
    const content = document.getElementById("content").value.trim();

    if (!title) {
        showAlert(" Judul harus diisi!", "error");
        return;
    }

    try {
        const payload = { title, content };
        
        if (id) {
            // Update
            await fetchAPI(`${API_BASE}/${id}`, {
                method: "PUT",
                body: JSON.stringify(payload)
            });
            showAlert(" Item diperbarui", "success");
        } else {
            // Create
            await fetchAPI(API_BASE, {
                method: "POST",
                body: JSON.stringify(payload)
            });
            showAlert(" Item ditambahkan", "success");
        }
        
        resetForm();
        await loadItems();  // Tunggu sampai selesai
    } catch (error) {
        // Error sudah ditangani
    }
});

// Cancel button
document.getElementById("cancel-btn").addEventListener("click", resetForm);

// Search functionality
document.getElementById("search-input").addEventListener("input", (e) => {
    const query = e.target.value.toLowerCase();
    const filtered = allItems.filter(item => 
        item.title.toLowerCase().includes(query) || 
        (item.content && item.content.toLowerCase().includes(query))
    );
    renderItems(filtered);
});

// Initial load
document.addEventListener("DOMContentLoaded", () => {
    console.log("Page loaded, starting to fetch items...");
    loadItems();
});
