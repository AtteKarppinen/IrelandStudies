# REMEMBER TO END COMMENTS WITH DOT!.
cat(cat).
cat(kittie).
dog(dog).

hates(X, Y) :- cat(X), dog(Y).
chases(X, Y) :- dog(X), cat(Y).
