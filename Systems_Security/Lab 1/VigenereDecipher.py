# Vigenere Cipher
# Key: KISWAHILI

# Formula used in deciphering:
# Ti = Ci - Ki {mod m}
# Ti = plaintext character
# Ci = ciphertext character
# Ki = key character
# m  = length of alphabet

import string

# Fetch alphabet from string library
alphabet = string.ascii_uppercase  


def generate_key(ciphertext, key_word):
    key = ""
    # Key gets splitted so each individual letter can be processed more easily
    key_splitted = list(key_word)
    # list_value is needed to match key length to ciphertext's
    list_value = 0

    for symbol in ciphertext:
        if symbol in alphabet:
            key = key + key_splitted[list_value]
            list_value += 1
            if list_value >= len(key_word):
                list_value = 0
        else:
            key = key + symbol
    return key

def decipher_message(ciphertext, key):
    plaintext = ""
    # Key gets splitted so each individual letter can be processed more easily
    key_splitted = list(key)

    for index, symbol in enumerate(ciphertext):
        if symbol in alphabet:
            # Capital ASCII values range from 65 to 90
            # +/-65 is required to count the deciphered letter's numerical value
            # (Used formula is explained above the code)
            letter_value = (ord(symbol) - 65) - (ord(key_splitted[index]) - 65)
            if letter_value < 0:
                letter_value += len(alphabet) + 65
                plaintext_character = chr(letter_value)
            else:
                letter_value += 65
                plaintext_character = chr(letter_value)
                
            plaintext = plaintext + plaintext_character
        else:
            plaintext = plaintext + symbol

    return plaintext


def main():
    key_word = "KISWAHILI"
    # Open text file and save it in string variable
    with open("encodedVigenere.txt", "r") as input_file:                         
        ciphertext = input_file.read()

    key = generate_key(ciphertext, key_word)
    print(decipher_message(ciphertext, key))

if __name__ == "__main__":
    main()