def is_prime_number(number):
    # An integer greater than one is called a prime number if its only positive divisors (factors) are one and itself. 
    if number > 1:
        # Check if number is divisible by any smaller integer
        for x in range(2, number):
            if number % x == 0:
                return False
        return True

    else:
        return False