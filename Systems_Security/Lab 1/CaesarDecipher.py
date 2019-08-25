from collections import Counter
import string

# Fetch alphabet from string library
alphabet = string.ascii_uppercase                                       

# Open text file and save it in string variable
with open("encodedCaesar.txt", "r") as input_file:                         
    encoded_msg = input_file.read()

# Count all letter occurances using Counter
count = Counter(encoded_msg)                                            

# Open file for writing (or appending)
with open("letterCount.txt", "w") as output_file:                       
    for letter in alphabet:
        output = "%s: %d" % (letter, count[letter])
        # print alphabet letter by letter
        print(output)                                                   
        output_file.write(output)
        output_file.write("\n")

# TEST: list of common words and if enough matches, print decoded message
common_words    = ["ONE", "TWO", "THREE", "THIS", "IS", "ON", "TO","AT", "IN", "THE", "AN", "WHAT", "THEN", "THAT"]
matches         = 0

for key in range(len(alphabet)):
    # Start with empty result in each loop
    decoded_message = ""

    for character in encoded_msg:
        # Ignore spaces and special characters
        if character in alphabet:
            # Get the location (number) of the character
            location_num = alphabet.find(character)
            # Adjust character by the value of the key
            location_num = location_num - key

            # Since range is 0-25, add length if negative number
            if location_num < 0:
                location_num = location_num + len(alphabet)

            # Append decryption with new value
            decoded_message = decoded_message + alphabet[location_num]

        # Add special characters as they are
        else:
            decoded_message = decoded_message + character

    # Make a list from the decrypted message
    split = decoded_message.split()
    # If there are more than three matches between common words list and decrypted message
    # assume it is in english and print only that
    if len(set(common_words) & set(split)) > 3:
        # Print key and decryption
        print("\nKey value: %s to right or %s to left \n%s" % (key, key - len(alphabet), decoded_message))