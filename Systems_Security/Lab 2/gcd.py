# Script to compute highest dividing factor
# using (extended) euclidian algorithm

def gcd_is_1(derived_number, totient): 
  
    while(totient): 
       derived_number, totient = totient, derived_number % totient

    if derived_number == 1:
        return True
    else:
        return False

# Modified from this:
# https://crypto.stackexchange.com/a/19530
# (Check in main code that private key is positive)
def extended_gcd(derived_number, totient):
    private_key, y, u, v = 0, 1, 1, 0
    while derived_number != 0:
        q, r = totient//derived_number, totient%derived_number
        m, n = private_key-u*q, y-v*q
        totient, derived_number, private_key, y, u, v = derived_number, r, u, v, m, n
    return private_key