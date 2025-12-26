#!/usr/bin/env python3
import sys
import json
import pytesseract
from PIL import Image
import cv2
import os

def ocr_image(path):
    """
    OCR pada file gambar (JPG, PNG) atau PDF halaman pertama yang sudah di-convert ke gambar
    """
    try:
        # Jika PDF, konversi halaman pertama ke gambar (opsional, butuh pdf2image)
        if path.lower().endswith(".pdf"):
            from pdf2image import convert_from_path
            pages = convert_from_path(path, dpi=300)
            if len(pages) == 0:
                return {}
            img = pages[0]
        else:
            img = Image.open(path)

        # Preprocessing sederhana
        img = img.convert('L')  # grayscale
        img = img.point(lambda x: 0 if x < 140 else 255)  # thresholding

        text = pytesseract.image_to_string(img, lang='eng+ind')
        text = text.lower()
        
        # Ambil info nama, nisn, tahun lulus
        result = {}
        lines = text.split('\n')
        for line in lines:
            line = line.strip()
            if 'nama' in line:
                result['nama'] = line.replace('nama', '').strip()
            elif 'nisn' in line:
                result['nisn'] = ''.join(filter(str.isdigit, line))
            elif 'tahun lulus' in line or 'tahun lulus:' in line:
                result['tahun_lulus'] = ''.join(filter(str.isdigit, line))
        return result
    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No file path provided"}))
        sys.exit(1)

    file_path = sys.argv[1]
    if not os.path.exists(file_path):
        print(json.dumps({"error": "File not found"}))
        sys.exit(1)

    result = ocr_image(file_path)
    print(json.dumps(result))