from PIL import Image, ImageDraw, ImageFont
import numpy as np
import cv2

# File paths
template_path = 'Template.png'
foto_path = 'foto.JPG'
output_path = 'output_id_card5.pdf'

# Data karyawan
nama = "Cobasepuluh Kata A."
departemen = "HRD"
level = "STAFF"
employee_id = "2412074309"

# Konfigurasi ukuran font per elemen
font_config = {
    "nama": {"path": "Futura-Bold.ttf", "size": 38},
    "departemen": {"path": "FUTURAMEDIUM.ttf", "size": 36},
    "level": {"path": "Futura.ttf", "size": 36},
    "employee_id": {"path": "FUTURAMEDIUM.ttf", "size": 36}
}

# Konfigurasi jarak antar elemen (dalam pixel)
spacing_config = {
    "foto_to_nama": 20,
    "nama_to_departemen": 24,
    "departemen_to_level": 20,
    "level_to_employee_id": 20
}

# Load font
def load_font(path, size):
    try:
        return ImageFont.truetype(path, size)
    except IOError:
        print(f"⚠️ Font '{path}' tidak ditemukan. Menggunakan default.")
        return ImageFont.load_default()

fonts = {
    key: load_font(cfg["path"], cfg["size"])
    for key, cfg in font_config.items()
}

# Baca template
template = Image.open(template_path).convert('RGB')
template_np = np.array(template)

# Warna target: kuning
target_rgb = np.array([246, 255, 0])
tolerance = 10

mask = np.all(
    np.abs(template_np - target_rgb) <= tolerance,
    axis=-1
).astype(np.uint8) * 255

contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

if contours:
    x, y, w, h = cv2.boundingRect(contours[0])

    foto = Image.open(foto_path).resize((w, h))
    template.paste(foto, (x, y))

    draw = ImageDraw.Draw(template)

    def draw_centered_text(text, y_pos, font):
        bbox = draw.textbbox((0, 0), text, font=font)
        text_width = bbox[2] - bbox[0]
        text_height = bbox[3] - bbox[1]
        draw.text((x + w // 2 - text_width // 2, y_pos), text, fill='black', font=font)
        return text_height

    # Posisi awal: setelah foto
    current_y = y + h + spacing_config["foto_to_nama"]

    # Nama
    current_y += draw_centered_text(nama, current_y, fonts["nama"]) + spacing_config["nama_to_departemen"]

    # Departemen
    current_y += draw_centered_text(departemen, current_y, fonts["departemen"]) + spacing_config["departemen_to_level"]

    # Level
    current_y += draw_centered_text(level, current_y, fonts["level"]) + spacing_config["level_to_employee_id"]

    # Employee ID
    draw_centered_text(employee_id, current_y, fonts["employee_id"])

    template.save(output_path)
    print(f"✅ Berhasil: Disimpan ke '{output_path}' dengan jarak antar elemen yang dapat dikustomisasi.")
else:
    print("❌ Kotak kuning tidak ditemukan.")
