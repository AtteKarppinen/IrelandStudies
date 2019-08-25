import sys
from random import SystemRandom
from primeNumber import is_prime_number
from gcd import gcd_is_1, computeGCD

# NOTICE!
# random.getrandbits() is faster than urandom (SystemRandom) but on this https://docs.python.org/2/library/random.html website
# there is a WARNING: The pseudo-random generators of this module should not be used for security purposes. 
# Use os.urandom() or SystemRandom if you require a cryptographically secure pseudo-random number generator.
# 
# Speed testing
# python -m timeit -s "import random" "random.getrandbits(128)"
# 1000000 loops, best of 5: 318 nsec per loop
# 
# python -m timeit -s "import os" "os.urandom(128)"
# 500000 loops, best of 5: 877 nsec per loop

# https://www.khanacademy.org/computing/computer-science/cryptography/modern-crypt/v/euler-s-totient-function-phi-function

def initialization():
    min_int = 100
    max_int = 200
    # Class that uses the os.urandom() function for generating random numbers from sources provided by the operating system.
    # Suitable for cryptographic reasons
    prime1 = SystemRandom().randint(min_int, max_int)
    prime2 = SystemRandom().randint(min_int, max_int)

    while not is_prime_number(prime1):
        prime1 = SystemRandom().randint(min_int, max_int)

    while not is_prime_number(prime2):
        prime2 = SystemRandom().randint(min_int, max_int)

    rsa_modulus = prime1 * prime2

    # Φ(n)
    totient = (prime1 - 1) * (prime2 - 1)

    # 1 < Derived Number (e) < Φ(n) (totient)
    # derived_number = SystemRandom().randint(1, totient)
    derived_number = SystemRandom().randint(min_int, totient)
    while (not gcd_is_1(derived_number, totient)) or (not is_prime_number(derived_number)):
        derived_number = SystemRandom().randint(min_int, totient)
    print(computeGCD(derived_number, totient))

    # If e is prime number all you need to do is check that derived_number (e) isn't a divisor of rsa_modulus (n)
    # while not is_prime_number(derived_number):
    #     derived_number = SystemRandom().randint(1, totient)

    # e.d=1 mod ø(n) and 0≤d≤n
    # d = ( k(random int) * Phi(n) + 1 ) / e
    private_key = int((2 * totient + 1) / derived_number)

    print('Is e Prime Number?', derived_number, is_prime_number(derived_number))
    print('Prime Number (p) ', prime1)
    print('Prime Number (q) ', prime2)
    print('Totient Phi(n) ', totient)
    print('Modulus (N)', rsa_modulus)
    print('Derived Number (e) ', derived_number)
    print('Private Key ', private_key)

    return rsa_modulus, derived_number, private_key


def encrypt(plaintext, rsa_modulus, derived_number):
    ciphertext = []
    for symbol in plaintext:
        # Cipher = m^e mod n
        cipher_symbol = ord(symbol)**derived_number % rsa_modulus
        # print('ord(symbol) ', ord(symbol))
        # print('ord(symbol)**derived ', ord(symbol), '**', derived_number, ' = ', ord(symbol)**derived_number)
        # print('rsa_mod ', rsa_modulus)
        # print('Cipher Symbol ', cipher_symbol)
        ciphertext.append(cipher_symbol)
        
    print('Ciphertext: ', ciphertext)
    return ciphertext


def decrypt(ciphertext, private_key, rsa_modulus):
    plaintext = ''
    for symbol in ciphertext:
        # Decipher C^d mod n
        plaintext_symbol = int(symbol ** private_key % rsa_modulus)
        plaintext_symbol = chr(plaintext_symbol)
        plaintext += plaintext_symbol

    print('Plaintext ', plaintext)

if __name__ == "__main__":
    return_values   = initialization()
    rsa_modulus     = return_values[0]
    derived_number  = return_values[1]
    private_key     = return_values[2]
    ciphertext      = encrypt('Testy test', rsa_modulus, derived_number)
    decrypt(ciphertext, private_key, rsa_modulus)