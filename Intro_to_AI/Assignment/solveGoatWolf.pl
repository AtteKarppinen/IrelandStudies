opp(e,w).
opp(w,e).
start(state(w,w,w,w)).
goal(state(e,e,e,e)).

unsafe(F,X,X,_) :- opp(F,X).
unsafe(F,_,X,X) :- opp(F,X).

% move(State1, State2).

% move the wolf
move(state(X,X,G,C), state(Y,Y,G,C)) :- 
    opp(X,Y), 
    not(unsafe(Y,Y,G,C)).


% move the goat
move(state(X,W,X,C), state(Y,W,Y,C)) :- 
    opp(X,Y), 
    not(unsafe(Y,W,Y,C)).


% move the cabbage
move(state(X,W,G,X), state(Y,W,G,Y)) :- opp(X,Y), not(unsafe(Y,W,G,Y)).

% move self only
move(state(X,W,G,C), state(Y,W,G,C)) :- opp(X,Y), not(unsafe(Y,W,G,C)).


solve(State, Soln) :-               solve(State, [], Solution),
                                    reverse(Solution, Soln).

solve(State, Path, [State|Path]) :- goal(State).

solve(State, Path, Solution) :-     move(State, Y),
                                    not(member(Y, Path)),
                                    solve(Y, [State|Path], Solution).

go :-   start(State),
        solve(State, Solution),
        showPath(Solution).


% Pretty printing code for FWGC solution path and states.
% showPath(Path)
showPath([]) :- nl.

showPath([S|Path]) :- 
    nl,showState(S),
    showPath(Path).


showState(S) :-
    showWest(S), write('|~~~~~~~|'), showEast(S),nl,
    write('    |~~~~~~~|').

showWest(state(F,W,G,C)) :-
    (F == w, write('F'), !; write(' ')),
    (W == w, write('W'), !; write(' ')),
    (G == w, write('G'), !; write(' ')),
    (C == w, write('C'), !; write(' ')).

showEast(state(F,W,G,C)) :-
    (F == e, write('F'), !; true),
    (W == e, write('W'), !; true),
    (G == e, write('G'), !; true),
    (C == e, write('C'), !; true).