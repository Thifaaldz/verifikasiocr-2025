class Book:
    def __init__(self, title, author, isbn, stock):
        self.title = title
        self.author = author
        self.isbn = isbn
        self.stock = stock

    def decrease_stock(self):
        if self.stock > 0:
            self.stock -= 1

    def increase_stock(self):
        self.stock += 1


class Member:
    def __init__(self, name, member_id):
        self.name = name
        self.member_id = member_id
        self.borrowed_books = []

class LibrarySystem:
    def borrow_book(self, member, book):
        if book.stock > 0:
            book.decrease_stock()
            member.borrowed_books.append(book)
            print(f"{member.name} meminjam buku {book.title}")
        else:
            print("Buku tidak tersedia")

    def return_book(self, member, book):
        if book in member.borrowed_books:
            member.borrowed_books.remove(book)
            book.increase_stock()
            print(f"{member.name} mengembalikan buku {book.title}")

class UserInterface:
    def display_book_info(self, book):
        print(f"Judul: {book.title}")
        print(f"Penulis: {book.author}")
        print(f"ISBN: {book.isbn}")
        print(f"Stok: {book.stock}")


        class BorrowDuration:
    def __init__(self, days):
        self.days = days


class EBook(Book):
    def __init__(self, title, author, isbn, file_size):
        super().__init__(title, author, isbn, stock=9999)
        self.file_size = file_size
