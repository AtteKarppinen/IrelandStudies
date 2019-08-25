man(jim).
man(mary).

mortal(X) :- man(X).
likes(X,A) :-man(X), dog(A).

dog(rex).
dog(lassie).

# a.
# b.
#
# c :- a;b
#
# person(jim, m, 23).
