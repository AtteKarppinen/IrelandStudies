# REMEMBER TO END COMMENTS WITH DOT!.
point(1,2).
point(3,2).
point(3,3).

segment(point(1,2), point(3,2)).
segment(point(1,2), point(3,3)).

# If X coordinate remains same but Y changes, line is vertical.
vertical(seg(point(X, _),point(X,_))).

horizontal(S) :-  S = segment(P1, P2),
                  P1 = point(X, Y),
                  P2 = point(Z, Y).
